<?php
/*
 * Script for run commands on client machine after boot
 * - delete certain item base on client's IP
 * - setup virtual memory swap file
 */

$ip = $_SERVER['REMOTE_ADDR'];

$file_lists = array(
  1 => array(
    array('type' => 'F', 'name' => 'C:\Documents and Settings\All Users\Start Menu\Programs\Microsoft Excel.lnk'),
    array('type' => 'F', 'name' => 'C:\Documents and Settings\All Users\Start Menu\Programs\Microsoft PowerPoint.lnk'),
    array('type' => 'F', 'name' => 'C:\Documents and Settings\All Users\Start Menu\Programs\Microsoft Word.lnk'),
    array('type' => 'D', 'name' => 'C:\Documents and Settings\All Users\Start Menu\Programs\Microsoft Office Tools'),
    array('type' => 'D', 'name' => 'C:\Program Files\Microsoft Office')
  )
);
$computers = array(
  '10.64.5.1' => 1,
  '10.64.5.2' => 1,
  '10.64.5.3' => 1,
  '10.64.5.4' => 1,
  '10.64.5.5' => 1,
  '10.64.5.6' => 1,
  '10.64.5.7' => 1,
  '10.64.5.8' => 1,
  '10.64.5.9' => 1,
  '10.64.5.10' => 1,
  '10.64.5.11' => 1,
  '10.64.5.12' => 1,
  '10.64.5.13' => 1,
  '10.64.5.14' => 1,
  '10.64.5.15' => 1,
  '10.64.5.16' => 1,
  '10.64.16.10' => 1,
  '10.64.16.11' => 1,
  '10.64.16.12' => 1,
  '10.64.16.13' => 1,
  '10.64.16.14' => 1,
  '10.64.16.15' => 1,
  '10.64.16.16' => 1,
  '10.64.16.17' => 1,
  '10.64.16.18' => 1
);

$create_swap = array(
  '10.64.5.1', '10.64.5.2', '10.64.5.3', '10.64.5.4', '10.64.5.5',
  '10.64.5.6', '10.64.5.7', '10.64.5.8', '10.64.5.9', '10.64.5.10',
  '10.64.5.11', '10.64.5.12', '10.64.5.13', '10.64.5.14', '10.64.5.15',
  '10.64.5.16',
  '10.64.16.1', '10.64.16.2', '10.64.16.3', '10.64.16.4', '10.64.16.5',
  '10.64.16.6', '10.64.16.7', '10.64.16.8', '10.64.16.9', '10.64.16.10',
  '10.64.16.11', '10.64.16.12', '10.64.16.13', '10.64.16.14', '10.64.16.15',
  '10.64.16.16', '10.64.16.17', '10.64.16.18', '10.64.16.19', '10.64.16.20',
  '10.64.16.21', '10.64.16.22', '10.64.16.23', '10.64.16.24', '10.64.16.25',
  '10.64.16.26'
);

echo "@echo off\n";
foreach ($file_lists[$computers[$ip]] as $file) {
  if ($file['type'] == 'F') {
    echo "del /q /f \"{$file['name']}\"\n";
  } else {
    echo "rmdir /q /s \"{$file['name']}\"\n";
  }
}
if (in_array($ip, $create_swap)) {
  echo "cscript //h:cscript //s\n";
  echo "pagefileconfig /create /i 1024 /m 1024 /vo c:\n";
}
