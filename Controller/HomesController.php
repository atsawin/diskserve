<?php
class HomesController extends AppController {

  public function index() {
  }

  public function run() {
    shell_exec("sudo /www/disksrv1.nakhon.net/app/script/run.sh");
  }

  public function update() {
    shell_exec("sudo /www/disksrv1.nakhon.net/app/script/update.sh");
  }

  public function clearCoW() {
    shell_exec("sudo /www/disksrv1.nakhon.net/app/script/clearCow.sh");
  }

  public function status() {
    $this->set('status', shell_exec("sudo /www/disksrv1.nakhon.net/app/script/status.sh"));
  }
}
