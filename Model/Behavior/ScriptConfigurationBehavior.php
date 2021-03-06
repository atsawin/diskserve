<?php

App::uses('Cluster', 'Model');
App::uses('Setting', 'Model');

class ScriptConfigurationBehavior extends ModelBehavior {

  public function afterSave(Model $model, $created) {
    $this->Cluster = new Cluster();
    $this->Setting = new Setting();
    $row = $this->Setting->find('first', array('conditions' => array('name' => 'script_path')));
    $script_path = $row['Setting']['value'];
    $row = $this->Setting->find('first', array('conditions' => array('name' => 'image_path')));
    $image_path = $row['Setting']['value'];
    $row = $this->Setting->find('first', array('conditions' => array('name' => 'cow_path')));
    $cow_path = $row['Setting']['value'];
    $row = $this->Setting->find('first', array('conditions' => array('name' => 'server_ip_address')));
    $server_ip_address = $row['Setting']['value'];
    $row = $this->Setting->find('first', array('conditions' => array('name' => 'server_iscsi_name')));
    $server_iscsi_name = $row['Setting']['value'];
    $clusters = $this->Cluster->find('all');
    $fp = fopen("{$script_path}/config/map.php", 'w');
    fwrite($fp, <<< EOM
<?php
\$computer_map = array(

EOM
    );
    foreach ($clusters as $cluster) {
      $alternatives = Set::combine($cluster['Alternative'], '{n}.id', '{n}');
      $variations = Set::combine($cluster['Variation'], '{n}.id', '{n}');
      foreach ($cluster['Computer'] as $computer) {
        if ($computer['alternative_id']) {
          $alternative_mode = $alternatives[$computer['alternative_id']]['mode'];
          $alternative_name = $alternatives[$computer['alternative_id']]['image'];
          $alternative_loop_name = $alternatives[$computer['alternative_id']]['loop_name'];
        } else {
          $alternative_mode = '';
          $alternative_name = '';
          $alternative_loop_name = '';
        }
        if ($computer['variation_id']) {
          $variation_name = $variations[$computer['variation_id']]['cow'];
        } else {
          $variation_name = '';
        }
        fwrite($fp, <<< EOM
  '{$computer['ip_address']}' => array(
    'computer_name' => '{$computer['name']}',
    'mode' => '{$computer['mode']}',
    'alternative_mode' => '{$alternative_mode}',
    'alternative_name' => '{$alternative_name}',
    'alternative_loop_name' => '{$alternative_loop_name}',
    'variation_name' => '{$variation_name}',
    'image_loop_name' => '{$cluster['Cluster']['loop_name']}',
    'cow_loop_name' => '{$computer['loop_name']}',
    'cow_size' => {$cluster['Cluster']['cow_size']},
    'cluster_id' => {$cluster['Cluster']['id']},
    'cluster_name' => '{$cluster['Cluster']['name']}'
  ),

EOM
        );
      }
    }
    fwrite($fp, <<< EOM
);
\$script_path = '{$script_path}';
\$image_path = '{$image_path}';
\$cow_path = '{$cow_path}';
\$server_iscsi_address = '{$server_ip_address}::::{$server_iscsi_name}';

EOM
    );
    fclose($fp);
    $fp = fopen("{$script_path}/config/startup.sh", 'w');
    fwrite($fp, "#!/bin/sh\n");
    foreach ($clusters as $cluster) {
      fwrite($fp, "losetup -r {$cluster['Cluster']['loop_name']} {$image_path}/{$cluster['Cluster']['name']}.img\n");
      foreach ($cluster['Alternative'] as $alternative) {
        if ($alternative['mode'] == 'S') {
          fwrite($fp, "losetup -r {$alternative['loop_name']} {$image_path}/{$alternative['image']}\n");
        }
      }
      foreach ($cluster['Computer'] as $computer) {
        fwrite($fp, "[ ! -e {$cow_path}/{$computer['name']}.cow ] && dd if=/dev/zero of={$cow_path}/{$computer['name']}.cow bs=1M count=0 seek={$cluster['Cluster']['cow_size']}\n");
      }
      fwrite($fp, "image_size=`blockdev --getsize {$cluster['Cluster']['loop_name']}`\n");
      foreach ($cluster['Computer'] as $computer) {
        fwrite($fp, "losetup {$computer['loop_name']} {$cow_path}/{$computer['name']}.cow\n");
      }
      foreach ($cluster['Computer'] as $computer) {
        fwrite($fp, "dmsetup create {$computer['name']} --table \"0 \${image_size} snapshot {$cluster['Cluster']['loop_name']} {$computer['loop_name']} p 64\"\n");
      }
    }
    fclose($fp);
    $fp = fopen("{$script_path}/config/ietd.conf", 'w');
    foreach ($clusters as $cluster) {
      fwrite($fp, "#Target {$server_iscsi_name}:{$cluster['Cluster']['name']}\n");
      fwrite($fp, "#  Lun 0 Path={$image_path}/{$cluster['Cluster']['name']}.img,Type=fileio\n");
      foreach ($cluster['Computer'] as $computer) {
        fwrite($fp, "Target {$server_iscsi_name}:{$computer['name']}\n");
        fwrite($fp, "  NOPInterval 60\n");
        fwrite($fp, "  NOPTimeout 60\n");
        fwrite($fp, "  Lun 0 Path=/dev/mapper/{$computer['name']},Type=fileio\n");
        for ($cnt_disk = 1; $cnt_disk <= $cluster['Cluster']['extra_disk']; $cnt_disk++) {
          fwrite($fp, "  Lun {$cnt_disk} Path={$image_path}/{$computer['name']}e{$cnt_disk}.img,Type=fileio\n");
        }
      }
    }
    fclose($fp);
    $fp = fopen("{$script_path}/config/shutdown.sh", 'w');
    fwrite($fp, <<<EOM
#!/bin/sh
dmsetup remove_all
dmsetup status
losetup -d /dev/loop[0-9]*

EOM
    );
    fclose($fp);
    $fp = fopen("{$script_path}/config/dhcpd.conf", 'w');
    foreach ($clusters as $cluster) {
      foreach ($cluster['Computer'] as $computer) {
        fwrite($fp, "host {$computer['name']} {\n");
        fwrite($fp, "  hardware ethernet {$computer['mac_address']};\n");
        fwrite($fp, "  fixed-address {$computer['ip_address']};\n");
        fwrite($fp, "}\n");
      }
    }
    fclose($fp);
  }
}
