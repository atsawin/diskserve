<?php

require_once('../script/config/map.php');

$ip = $_SERVER['REMOTE_ADDR'];
$computer_name = $computer_map[$ip]['computer_name'];
$loop_name = $computer_map[$ip]['loop_name'];

$iet = file('/proc/net/iet/volume');
foreach ($iet as $line) {
  $line = trim($line);
  if (preg_match('/^tid:(\d+) name:[0-9A-Za-z\-\.]+:([0-9A-Za-z]+)$/', $line, $match) == 1) {
    if ($match[2] == $computer_name) {
      $tid = $match[1];
    }
  }
}

shell_exec("sudo /www/disksrv1.nakhon.net/app/script/newcow.sh {$computer_name} {$tid} /dev/loop0 {$loop_name} 5120");

echo <<<EOM
#!ipxe

dhcp
set root-path iscsi:10.64.2.1::::iqn.1999-06.net.nakhon.server3:{$computer_name}
sanboot \${root-path}

EOM;
