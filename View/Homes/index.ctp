<div class="view">
  <h2>สถานะระบบ</h2>
  <pre>
    <?php
      $mode_map = array('R' => 'Run', 'U' => 'Update on computer ');
      echo "<h2>Mode</h2>\n";
      foreach ($mode as $cluster_id => $cluster) {
        echo "{$cluster['name']}: {$mode_map[$cluster['mode']]}{$cluster['computer']}\n";
      }
      echo "\n";
      echo $status;
    ?>
  </pre>
</div>
<?php echo $this->element('menu'); ?>
