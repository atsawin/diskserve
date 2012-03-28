<div class="view">
  <h2>เปลี่ยน Mode การทำงาน</h2>
  <h3>ปิดเครื่องลูกทุกเครื่องก่อนเรียกคำสั่ง</h3>
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
           'before' => $this->Form->label("{$cluster['Cluster']['id']}Mode"),
           'options' => array('R' => 'Run', 'U' => 'Update'),
           'value' => $mode[$cluster['Cluster']['id']]['mode'],
           'div' => array('radioToggle' => "Cluster{$cluster['Cluster']['id']}Mode")));
       echo $this->Html->div('',
         $this->Form->input("{$cluster['Cluster']['id']}.computer", array('type' => 'select', 'options' => $computers,
           'label' => 'Update Computer', 'value' => $mode[$cluster['Cluster']['id']]['computer'])),
         array('blockName' => "Cluster{$cluster['Cluster']['id']}Mode", 'blockValues' => 'U')
       );
       echo "</fieldset>\n";
     }
     echo $this->Form->end(__('Submit'));
  ?>
</div>
<?php echo $this->element('menu'); ?>
