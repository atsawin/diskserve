<?php

require_once('../script/config/map.php');
require_once('../script/config/mode.php');

$ip = $_SERVER['REMOTE_ADDR'];
$computer_name = $computer_map[$ip]['computer_name'];
$image_loop_name = $computer_map[$ip]['image_loop_name'];
$cow_loop_name = $computer_map[$ip]['cow_loop_name'];
$cow_size = $computer_map[$ip]['cow_size'];
$cluster_id = $computer_map[$ip]['cluster_id'];
$cluster_name = $computer_map[$ip]['cluster_name'];

$iet = file('/proc/net/iet/volume');
foreach ($iet as $line) {
  $line = trim($line);
  if (preg_match('/^tid:(\d+) name:[0-9A-Za-z\-\.]+:([0-9A-Za-z]+)$/', $line, $match) == 1) {
    if ($match[2] == $computer_name) {
      $tid = $match[1];
    }
  }
}

if ($mode[$cluster_id]['mode'] == 'U') {
  // Update mode
  if ($mode[$cluster_id]['computer'] == $computer_name) {
    // This computer is use for update, send master image
    echo <<<EOM
#!ipxe

dhcp
set root-path iscsi:{$server_iscsi_address}:{$cluster_name}
sanboot \${root-path}

EOM;
  } else {
    // This computer is not use for update, send Linux
    echo <<<EOM
#!ipxe

dhcp
chain http://disksrv1.nakhon.net/memtest86

EOM;
//chain http://disksrv1.nakhon.net/vmlinuz-2.6.32.33-s1 nfsroot=10.64.2.1:/InterSol/ThinServ/s1 ip=::::::dhcp
  }
} else {
  shell_exec("sudo {$script_path}/newcow.sh {$computer_name} {$tid} {$image_loop_name} {$cow_loop_name} {$cow_size}");
  echo <<<EOM
#!ipxe

dhcp
set root-path iscsi:{$server_iscsi_address}:{$computer_name}
sanboot \${root-path}

EOM;
}
