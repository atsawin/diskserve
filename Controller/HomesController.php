<?php
class HomesController extends AppController {

  var $uses = array('Cluster', 'Computer');

  public function index() {
    $script_path = $this->getScriptPath();
    $clusters = $this->Cluster->find('all', array(
      'order' => 'id'
    ));
    $ret = shell_exec("sudo {$script_path}/status.sh");
    $status = explode("\n", $ret);
    $mode = '';
    foreach ($clusters as &$cluster) {
      foreach ($cluster['Computer'] as &$computer) {
        $computer['cow_size'] = 0;
        $computer['cow_used'] = 0;
      }
      unset($computer);
    }
    unset($cluster);
    foreach ($status as $line) {
      if (preg_match('/^::(.+)$/', $line, $match)) {
        $mode = $match[1];
      } else {
        if ($mode == 'cow') {
          $line_array = preg_split('/[: \/]/', $line);
          foreach ($clusters as &$cluster) {
            foreach ($cluster['Computer'] as &$computer) {
              if (($computer['name'] == $line_array[0]) && (count($line_array) > 7)) {
                $computer['cow_size'] = $line_array[6] / 2;
                $computer['cow_used'] = $line_array[5] / 2;
              }
            }
            unset($computer);
          }
          unset($cluster);
        }
      }
    }
    $this->set('status', preg_replace("/\n::(.+)\n/", "\n\n<h2>$1</h2>\n", $ret));
    $this->set('clusters', $clusters);
  }

  public function merge() {
    $clusters = $this->Cluster->find('all', array('order' => 'id'));
    if ($this->request->is('post')) {
      $data = $this->request->data['Cluster'];
      $this->Session->write('data', $data);
      $this->Session->write('clusters', $clusters);
      $script_path = $this->getScriptPath();
      shell_exec("sudo {$script_path}/stop.sh >> /tmp/b 2>&1");
      foreach ($data as $cluster_id => $cluster) {
        if ($cluster['mode'] != 'U') {
          continue;
        }
        $this->start_merge($clusters, $script_path, $cluster_id, $cluster);
        break;
      }
      $this->Session->setFlash(__('Merging...'));
      $this->redirect(array('action' => 'merge_update'));
    }
    $this->set('clusters', $clusters);
  }

  protected function start_merge($clusters, $script_path, $cluster_id, $cluster) {
    $current_cluster = array();
    foreach ($clusters as $search_cluster) {
      if ($search_cluster['Cluster']['id'] == (int)$cluster_id) {
        $current_cluster = $search_cluster;
      }
    }
    $image_path = $this->getSetting('image_path');
    $cow_path = $this->getSetting('cow_path');
    $computers = '';
    foreach ($current_cluster['Computer'] as $computer) {
      $computers .= " {$computer['name']}";
      if ($computer['name'] == $cluster['computer']) {
        $current_computer = $computer;
      }
    }
    shell_exec("sudo {$script_path}/mergecow_start.sh {$image_path} {$current_cluster['Cluster']['name']} " .
        "{$current_cluster['Cluster']['loop_name']} {$cow_path} {$cluster['computer']} {$current_computer['loop_name']} >> /tmp/b 2>&1");
    $merge = array(
      'cluster_id' => $cluster_id,
      'image_path' => $image_path,
      'cluster_name' => $current_cluster['Cluster']['name'],
      'image_loop_name' => $current_cluster['Cluster']['loop_name'],
      'cow_path' => $cow_path,
      'computer_name' => $cluster['computer'],
      'cow_loop_name' => $current_computer['loop_name'],
      'cow_size' => $current_cluster['Cluster']['cow_size'],
      'computers' => $computers
    );
    $this->Session->write('merge', $merge);
  }

  public function merge_update() {
    $merge = $this->Session->read('merge');
    $data = $this->Session->read('data');
    $clusters = $this->Session->read('clusters');
    if (empty($merge) || empty($data) || empty($clusters)) {
      $this->Session->setFlash(__('Invalid merge session'));
      $this->redirect(array('action' => 'index'));
    }
    $script_path = $this->getScriptPath();
    $ret = shell_exec("sudo {$script_path}/mergecow_status.sh {$merge['image_path']} {$merge['cluster_name']} " .
        "{$merge['image_loop_name']} {$merge['cow_path']} {$merge['computer_name']} {$merge['cow_loop_name']}");
    $line_array = preg_split('/[ \/]/', $ret);
    $status = array(
      'pending_size' => $line_array[3] / 2,
      'meta_size' => $line_array[5] / 2
    );
    if (empty($merge['cow_usage_size'])) {
      $merge['cow_usage_size'] = $status['pending_size'];
      $this->Session->write('merge', $merge);
    }
    if ($status['pending_size'] == $status['meta_size']) {
      shell_exec("sudo {$script_path}/mergecow_finish.sh {$merge['image_path']} {$merge['cluster_name']} " .
        "{$merge['image_loop_name']} {$merge['cow_path']} {$merge['computer_name']} {$merge['cow_loop_name']} >> /tmp/b 2>&1");
      shell_exec("sudo {$script_path}/clearcows.sh {$merge['cow_path']} {$merge['cow_size']} {$merge['computers']} >> /tmp/b 2>&1");
      foreach ($data as $cluster_id => $cluster) {
        if ($cluster_id <= $merge['cluster_id']) {
          continue;
        }
        if ($cluster['mode'] != 'U') {
          continue;
        }
        $this->start_merge($clusters, $script_path, $cluster_id, $cluster);
        $this->redirect(array('action' => 'merge_update'));
      }
      shell_exec("sudo {$script_path}/start.sh >> /tmp/b 2>&1");
      $this->Session->setFlash(__('Merge Done!'));
      $this->redirect(array('action' => 'index'));
    }
    $this->set('merge', $merge);
    $this->set('status', $status);
  }

  public function mode() {
    $clusters = $this->Cluster->find('all');
    if ($this->request->is('post')) {
      $data = array();
      foreach ($this->request->data['Computer'] as $computer_id => $computer) {
        if (($computer['mode'] == 'T') || ($computer['mode'] == 'P')) {
          $data[] = array('id' => $computer_id, 'mode' => $computer['mode'], 'alternative_id' => null);
        } else {
          $data[] = array('id' => $computer_id, 'mode' => 'A', 'alternative_id' => $computer['mode']);
        }
      }
      $this->Computer->saveMany($data);
      $this->Session->setFlash(__('Mode changed'));
      $this->redirect(array('action' => 'index'));
    }
    $this->set('clusters', $clusters);
  }

  public function restart() {
    if ($this->request->is('post')) {
      $script_path = $this->getScriptPath();
      $this->set('result', shell_exec("sudo {$script_path}/restart.sh"));
      $this->Session->setFlash(__('Service restarted'));
      $this->redirect(array('action' => 'index'));
    }
  }
}
