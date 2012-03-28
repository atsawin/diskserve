<?php
class HomesController extends AppController {

  var $uses = array('Cluster');

  public function index() {
    include '../script/config/mode.php';

    $script_path = $this->getScriptPath();
    $this->set('status', shell_exec("sudo {$script_path}/status.sh"));
    $this->set('mode', $mode);
  }

  public function run() {
    $script_path = $this->getScriptPath();
    shell_exec("sudo {$script_path}/run.sh");
  }

  public function update() {
    $script_path = $this->getScriptPath();
    shell_exec("sudo {$script_path}/update.sh");
  }

  public function clearCoW() {
    $script_path = $this->getScriptPath();
    shell_exec("sudo {$script_path}/clearCow.sh");
  }

  public function status() {
    $script_path = $this->getScriptPath();
    $this->set('status', shell_exec("sudo {$script_path}/status.sh"));
  }

  public function mode() {
    include '../script/config/mode.php';

    $clusters = $this->Cluster->find('all');
    if ($this->request->is('post')) {
      $script_path = $this->getScriptPath();
      $fp = fopen("{$script_path}/config/mode.php", 'w');
      fwrite($fp, "<?php\n");
      fwrite($fp, "\$mode = array(\n");
      foreach ($this->request->data['Cluster'] as $cluster_id => $cluster) {
        $current_cluster = array();
        foreach ($clusters as $search_cluster) {
          if ($search_cluster['Cluster']['id'] == (int)$cluster_id) {
            $current_cluster = $search_cluster;
          }
        }
        if (!array_key_exists('computer', $cluster)) {
          $cluster['computer'] = '';
        }
        fwrite($fp, "  {$cluster_id} => array('mode' => '{$cluster['mode']}', 'computer' => '{$cluster['computer']}', " .
            "'name' => '{$current_cluster['Cluster']['name']}'),\n");
      }
      fwrite($fp, ");\n");
      fclose($fp);
      $this->Session->setFlash(__('Mode changed'));
      $this->redirect(array('action' => 'mode'));
    }
    $this->set('clusters', $clusters);
    $this->set('mode', $mode);
  }
}
