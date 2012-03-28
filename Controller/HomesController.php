<?php
class HomesController extends AppController {

  var $uses = array('Cluster');

  public function index() {
    $script_path = $this->getScriptPath();
    $this->set('status', shell_exec("sudo {$script_path}/status.sh"));
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

    if ($this->request->is('post')) {
      $script_path = $this->getScriptPath();
      $fp = fopen("{$script_path}/config/mode.php", 'w');
      fwrite($fp, "<?php\n");
      fwrite($fp, "\$mode = array(\n");
      foreach ($this->request->data['Cluster'] as $cluster_id => $cluster) {
        fwrite($fp, "  {$cluster_id} => array('mode' => '{$cluster['mode']}', 'computer' => '{$cluster['computer']}'),\n");
      }
      fwrite($fp, ");\n");
      fclose($fp);
      $this->Session->setFlash(__('Mode changed'));
      $this->redirect(array('action' => 'mode'));
    }
    $this->set('clusters', $this->Cluster->find('all'));
    $this->set('mode', $mode);
  }
}
