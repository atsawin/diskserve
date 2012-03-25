<?php

App::uses('ClusterModel', 'Model');

class ScriptConfigurationBehavior extends ModelBehavior {

  public function afterSave(Model $model, $created) {
    $this->Cluster = new Cluster();
    $clusters = $this->Cluster->find('all');
    $fp = fopen('/www/disksrv1.nakhon.net/app/script/config/map.php', 'w');
    fwrite($fp, <<< EOM
<?php
\$computer_map = array(

EOM
    );
    foreach ($clusters as $cluster) {
      foreach ($cluster['Computer'] as $computer) {
        fwrite($fp, <<< EOM
  '{$computer['ip_address']}' => array(
    'computer_name' => '{$computer['name']}',
    'loop_name' => '{$computer['loop_name']}'
  ),

EOM
        );
      }
    }
    fwrite($fp, <<< EOM
);

EOM
    );
    fclose($fp);
  }
}
