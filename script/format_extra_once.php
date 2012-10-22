#!/usr/bin/php
<?php
/*
 * Script to format extra disk.
 * This script should be run from cron.
 */

$directory = '/image';
$num_disk = 1;
$computer_clusters = array(
  'net' => array(
    '01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
    '11', '12',
  ),
  'spice' => array(
    '01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
    '11', '12', '13', '14', '15', '16',
  ),
);

$losetup = '/sbin/losetup';
$mkfs = '/sbin/mkfs.ntfs -f -I -L DRIVE_D';

$ret = shell_exec("{$losetup} -f");
$lodevice = trim($ret);
foreach ($computer_clusters as $prefix => $computers) {
  foreach ($computers as $computer) {
    for ($disk = 1; $disk <= $num_disk; $disk++) {
      shell_exec("{$losetup} -o 1048576 {$lodevice} {$directory}/{$prefix}{$computer}e{$disk}.img\n");
      shell_exec("{$mkfs} {$lodevice}\n");
      sleep(1);
      shell_exec("{$losetup} -d {$lodevice}\n");
    }
  }
}
