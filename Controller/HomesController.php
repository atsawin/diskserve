<?php
class HomesController extends AppController {

  public function index() {
  }

  public function run() {
    shell_exec("sudo /www/disksrv2/app/script/run.sh");
  }

  public function update() {
    shell_exec("sudo /www/disksrv2/app/script/update.sh");
  }

  public function clearCoW() {
    shell_exec("sudo /www/disksrv2/app/script/clearCow.sh");
  }

  public function status() {
    $this->set('status', shell_exec("sudo /www/disksrv2/app/script/status.sh"));
  }
}
