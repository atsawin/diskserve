<?php

require_once('../script/config/map.php');

$ip = $_SERVER['REMOTE_ADDR'];
$computer_name = $computer_map[$ip]['computer_name'];
$image_loop_name = $computer_map[$ip]['image_loop_name'];
$cow_loop_name = $computer_map[$ip]['cow_loop_name'];
$cow_size = $computer_map[$ip]['cow_size'];

$iet = file('/proc/net/iet/volume');
foreach ($iet as $line) {
  $line = trim($line);
  if (preg_match('/^tid:(\d+) name:[0-9A-Za-z\-\.]+:([0-9A-Za-z]+)$/', $line, $match) == 1) {
    if ($match[2] == $computer_name) {
      $tid = $match[1];
    }
  }
}

shell_exec("sudo {$script_path}/newcow.sh {$computer_name} {$tid} {$image_loop_name} {$cow_loop_name} {$cow_size}");

echo <<<EOM
#!ipxe

dhcp
set root-path iscsi:{$server_iscsi_address}:{$computer_name}
sanboot \${root-path}

EOM;
