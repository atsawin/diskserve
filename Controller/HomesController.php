<?php
class HomesController extends AppController {

  var $uses = array('Cluster');

  public function index() {
    $script_path = $this->getScriptPath();
    $this->set('status', shell_exec("sudo {$script_path}/status.sh"));
  }

  public function merge() {
    $clusters = $this->Cluster->find('all');
    if ($this->request->is('post')) {
      $tmp = print_r($this->request->data, true);
      $script_path = $this->getScriptPath();
      $image_path = $this->getSetting('image_path');
      $cow_path = $this->getSetting('cow_path');
      shell_exec("sudo {$script_path}/stop.sh >> /tmp/b 2>&1");
      foreach ($this->request->data['Cluster'] as $cluster_id => $cluster) {
        if ($cluster['mode'] != 'U') {
          continue;
        }
        $current_cluster = array();
        foreach ($clusters as $search_cluster) {
          if ($search_cluster['Cluster']['id'] == (int)$cluster_id) {
            $current_cluster = $search_cluster;
          }
        }
        $computers = '';
        foreach ($current_cluster['Computer'] as $computer) {
          $computers .= " {$computer['name']}";
          if ($computer['name'] == $cluster['computer']) {
            $current_computer = $computer;
          }
        }
        shell_exec("sudo {$script_path}/mergecow.sh {$image_path} {$current_cluster['Cluster']['name']} " .
            "{$current_cluster['Cluster']['loop_name']} {$cow_path} {$cluster['computer']} {$current_computer['loop_name']} >> /tmp/b 2>&1");
        shell_exec("sudo {$script_path}/clearcows.sh {$cow_path} {$current_cluster['Cluster']['cow_size']} {$computers} >> /tmp/b 2>&1");
      }
      shell_exec("sudo {$script_path}/start.sh >> /tmp/b 2>&1");
      $this->Session->setFlash(__('Merge completed'));
      $this->redirect(array('action' => 'index'));
    }
    $this->set('clusters', $clusters);
  }

  public function mode() {
    $clusters = $this->Cluster->find('all');
    if ($this->request->is('post')) {
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
