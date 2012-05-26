<div class="view">
  <h2>สถานะระบบ</h2>
  <table class="list">
  <?php
    $columns = 2;
    echo "<tr>\n";
    for ($cnt_col = 0; $cnt_col < $columns; $cnt_col++) {
      echo "<th>ที่</th>\n";
      echo "<th>ชื่อ</th>\n";
      echo "<th>IP</th>\n";
      echo "<th>เนื้อที่คงเหลือ</th>\n";
      echo "<th>Mode</th>\n";
    }
    echo "</tr>\n";
    $cluster_span = $columns * 5;
    foreach ($clusters as $cluster) {
      echo "<tr>\n";
      echo "<th colspan=\"{$cluster_span}\">{$cluster['Cluster']['name']}</th>\n";
      echo "</tr>\n";
      $total = count($cluster['Computer']);
      $row_per_col = ceil($total / $columns);
      $cnt = 0;
      $cnt_col = 0;
      for ($cnt_row = 0; $cnt_row < $row_per_col; $cnt_row++) {
        echo "<tr>\n";
        for ($cnt_col = 0; $cnt_col < $columns; $cnt_col++) {
          if ($cnt_col * $row_per_col + $cnt_row < $total) {
            $computer = $cluster['Computer'][$cnt_col * $row_per_col + $cnt_row];
            $cow_left = ($computer['cow_size'] - $computer['cow_used']) / 1024;
	    if ($cow_left < $computer['cow_size'] / 1024 / 8) {
              $warn = ' warn_level1';
	    } else if ($cow_left < $computer['cow_size'] / 1024 / 4) {
              $warn = ' warn_level2';
	    } else if ($cow_left < $computer['cow_size'] / 1024 / 2) {
              $warn = ' warn_level3';
	    } else {
              $warn = '';
	    }
            if ($computer['mode'] == 'T') {
              $mode = 'ปกติ-ล้างทุกครั้ง';
            } else if ($computer['mode'] == 'P') {
              $mode = 'ปกติ-ไม่ล้าง';
            } else if ($computer['mode'] == 'A') {
              foreach ($cluster['Alternative'] as $alternative) {
                if ($alternative['id'] == $computer['alternative_id']) {
                  $mode = $alternative['name'];
                  break;
                }
              }
            }
            echo "<td>" . ($cnt_col * $row_per_col + $cnt_row + 1) . "</td>\n";
            echo "<td>{$computer['name']}</td>\n";
            echo "<td>{$computer['ip_address']}</td>\n";
            echo "<td class=\"number{$warn}\">" . $this->Number->format($cow_left, array('before' => '', 'places' => 2)) . " MiB</td>\n";
            echo "<td>{$mode}</td>\n";
          }
        }
        echo "</tr>\n";
      }
    }
  ?>
  </table>
  <pre>
    <?php
      //print_r($clusters);
      echo $status;
    ?>
  </pre>
</div>
<?php echo $this->element('menu'); ?>
