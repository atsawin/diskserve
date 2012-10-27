<?php

App::uses('Setting', 'Model');

class ScriptSettingBehavior extends ModelBehavior {

  public function afterSave(Model $model, $created) {
    $this->Setting = new Setting();
    $row = $this->Setting->find('first', array('conditions' => array('name' => 'script_path')));
    $script_path = $row['Setting']['value'];
    $row = $this->Setting->find('first', array('conditions' => array('name' => 'image_backup_path')));
    $image_backup_path = $row['Setting']['value'];
    $fp = fopen("{$script_path}/config/setting.sh", 'w');
    fwrite($fp, "IMAGE_BACKUP_PATH={$image_backup_path}\n");
    fclose($fp);
  }
}
