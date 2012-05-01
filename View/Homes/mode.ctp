<div class="view">
  <h2>กำหนดรูปแบบการใช้งานของเครื่องลูก</h2>
  <h3>ค่าที่กำหนดจะมีผลในการบูตเครื่องลูกครั้งต่อไป</h3>
  <?php
    echo $this->Form->create('Computer');
    foreach ($clusters as $cluster) {
      echo "<fieldset>\n";
      echo "<legend>{$cluster['Cluster']['name']}</legend>\n";
      echo "<table class=\"list\">\n<tr>\n<th>Computer</th>\n<th>ปกติ-ล้างทุกครั้ง</th>\n<th>ปกติ-ไม่ล้าง</th>\n";
      foreach ($cluster['Alternative'] as $alternative) {
        echo "<th>{$alternative['name']}</th>\n";
      }
      echo "</tr>\n";
      foreach ($cluster['Computer'] as $computer) {
        if ($computer['mode'] == 'A') {
          $mode = "{$computer['alternative_id']}";
        } else {
          $mode = $computer['mode'];
        }
        echo "<tr>\n<td>{$computer['name']}</td>\n";
        echo "<td>" . $this->Form->radio("Computer.{$computer['id']}.mode",
            array('T' => ''), array('value' => $mode, 'label' => false, 'hiddenField' => false)) . "</td>\n";
        echo "<td>" . $this->Form->radio("Computer.{$computer['id']}.mode",
            array('P' => ''), array('value' => $mode, 'label' => false, 'hiddenField' => false)) . "</td>\n";
        foreach ($cluster['Alternative'] as $alternative) {
          echo "<td>" . $this->Form->radio("Computer.{$computer['id']}.mode",
              array("{$alternative['id']}" => ''), array('value' => $mode, 'label' => false, 'hiddenField' => false)) . "</td>\n";
        }
        echo "</tr>\n";
      }
      echo "</table>\n";
      echo "</fieldset>\n";
    }
    echo $this->Form->end(__('Submit'));
  ?>
</div>
<?php echo $this->element('menu'); ?>
