<?php

require_once('../script/config/map.php');

$ip = $_SERVER['REMOTE_ADDR'];
$computer_name = $computer_map[$ip]['computer_name'];
$mode = $computer_map[$ip]['mode'];
$alternative_mode = $computer_map[$ip]['alternative_mode'];
$alternative_name = $computer_map[$ip]['alternative_name'];
$alternative_loop_name = $computer_map[$ip]['alternative_loop_name'];
$image_loop_name = $computer_map[$ip]['image_loop_name'];
$cow_loop_name = $computer_map[$ip]['cow_loop_name'];
$cow_size = $computer_map[$ip]['cow_size'];
$cluster_id = $computer_map[$ip]['cluster_id'];
$cluster_name = $computer_map[$ip]['cluster_name'];

$iet = shell_exec("{$script_path}/volume.sh");
foreach ($iet as $line) {
  $line = trim($line);
  if (preg_match('/^tid:(\d+) name:[0-9A-Za-z\-\.]+:([0-9A-Za-z]+)$/', $line, $match) == 1) {
    if ($match[2] == $computer_name) {
      $tid = $match[1];
    }
  }
}

if (($mode == 'T') || (($mode == 'A') && ($alternative_mode == 'S'))) {
  if ($mode == 'T') {
    $loop_name = $image_loop_name;
  } else {
    $loop_name = $alternative_loop_name;
  }
  shell_exec("sudo {$script_path}/newcow.sh {$computer_name} {$tid} {$image_path} {$loop_name} {$cow_path} " .
      "{$cow_loop_name} {$cow_size}");
}
if (($mode == 'T') || ($mode == 'P') || (($mode == 'A') && ($alternative_mode == 'S'))) {
  echo <<<EOM
#!ipxe

dhcp
set root-path iscsi:{$server_iscsi_address}:{$computer_name}
sanboot \${root-path}

EOM;
} else if ($alternative_mode == 'C') {
  echo <<<EOM
#!ipxe

dhcp
chain http://disksrv1.nakhon.net/{$alternative_name}

EOM;
}
