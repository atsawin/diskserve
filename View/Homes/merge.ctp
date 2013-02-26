<div class="view">
  <h2>รวมการ Update จากเครื่องลูก</h2>
  <h3>ปิดเครื่องลูกทุกเครื่องก่อนเรียกคำสั่ง</h3>
  <?php
     echo $this->Form->create('Cluster');
     foreach ($clusters as $cluster) {
       $computers = array();
       foreach ($cluster['Computer'] as $computer) {
         $computers['C' . $computer['id']] = $computer['name'];
       }
       foreach ($cluster['Variation'] as $variation) {
         $computers['V' . $variation['id']] = $variation['name'];
       }
       echo "<fieldset>\n";
       echo "<legend>{$cluster['Cluster']['name']}</legend>\n";
       echo $this->Form->input("{$cluster['Cluster']['id']}.mode", array('type' => 'radio', 'legend' => false,
           'before' => $this->Form->label("Update"),
           'options' => array('N' => 'No, do not update', 'U' => 'Yes, update'),
           'value' => 'N',
           'div' => array('radioToggle' => "Cluster{$cluster['Cluster']['id']}Mode")));
       echo $this->Html->div('',
         $this->Form->input("{$cluster['Cluster']['id']}.computer", array('type' => 'select', 'options' => $computers,
           'label' => 'Update From', 'value' => '')),
         array('blockName' => "Cluster{$cluster['Cluster']['id']}Mode", 'blockValues' => 'U')
       );
       echo "</fieldset>\n";
     }
     echo $this->Form->end(__('Submit'));
  ?>
</div>
<?php echo $this->element('menu'); ?>
