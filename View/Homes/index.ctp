<div class="view">
  <h2>สถานะระบบ</h2>
  <table>
    <tr>
      <th>ที่</th>
      <th>ชื่อ</th>
      <th>IP</th>
      <th>เนื้อที่คงเหลือ</th>
      <th>Mode</th>
    </tr>
  <?php
    foreach ($clusters as $cluster) {
      echo "<tr>\n";
      echo "<th colspan=\"5\">{$cluster['Cluster']['name']}</th>\n";
      echo "</tr>\n";
      $cnt = 0;
      foreach ($cluster['Computer'] as $computer) {
        $cnt++;
        $cow_left = ($computer['cow_size'] - $computer['cow_used']) / 1024;
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
        echo "<tr>\n";
        echo "<td>{$cnt}</td>\n";
        echo "<td>{$computer['name']}</td>\n";
        echo "<td>{$computer['ip_address']}</td>\n";
        echo "<td class=\"number\">" . $this->Number->format($cow_left, array('before' => '', 'places' => 2)) . " MiB</td>\n";
        echo "<td>{$mode}</td>\n";
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
