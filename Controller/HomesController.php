<?php
class HomesController extends AppController {

  var $uses = array('Setting');

  public function index() {
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
}
