<div class="view">
  <h2>เปลี่ยน Mode การทำงาน</h2>
  <?php
     echo $this->Form->create('Cluster');
     foreach ($clusters as $cluster) {
       $computers = array();
       foreach ($cluster['Computer'] as $computer) {
         $computers[$computer['name']] = $computer['name'];
       }
       echo "<fieldset>\n";
       echo "<legend>{$cluster['Cluster']['name']}</legend>\n";
       echo $this->Form->input("{$cluster['Cluster']['id']}.mode", array('type' => 'radio', 'legend' => false,
           'before' => $this->Form->label('Mode'),
           'options' => array('R' => 'Run', 'U' => 'Update'),
           'value' => $mode[$cluster['Cluster']['id']]['mode']));
       echo $this->Form->input("{$cluster['Cluster']['id']}.computer", array('type' => 'select', 'options' => $computers,
           'value' => $mode[$cluster['Cluster']['id']]['computer']));
       echo "</fieldset>\n";
     }
     echo $this->Form->end(__('Submit'));
  ?>
</div>
<?php echo $this->element('menu'); ?>
