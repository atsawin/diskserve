#!/usr/bin/php
<?php
/*
 * Script to format extra disk.
 * This script should be run from cron.
 */

$run_file = '/www/disksrv2/app/script/format_extra_run.php';

require_once($run_file);

$run_day = 3; // 0-Sunday, 6-Saturday
$run_hour = 8;

$directory = '/image';
$prefix = 'spice';
$num_disk = 1;
$ip_prefix = '10.64.16.';
$computers = array(
  '01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
  '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
  '21', '22', '23', '24', '25', '26', '27', '28', '29', '30',
  '31', '32', '33', '34', '35', '36', '37', '38', '39', '40',
  '41', '42', '43', '44', '45', '46', '47'
);

$losetup = '/sbin/losetup';
$mkfs = '/sbin/mkfs.ntfs -f -I -L Drive_D';

$now = time();
$localtime = localtime($now, true);
$date = $localtime['tm_mday'] - $localtime['tm_wday'] + $run_day;
print("date: {$date}\n");
$run_timestamp = mktime($run_hour, 0, 0, $localtime['tm_mon'] + 1, $date, $localtime['tm_year'] + 1900);
if ($run_timestamp > $now) {
  $run_timestamp -= 604800;
}
print("now: {$now}\n");
print("run: {$run_timestamp}\n");
$ret = shell_exec("{$losetup} -f");
$lodevice = trim($ret);
foreach ($computers as $computer) {
  if ($run_timestamp > $last_run[$computer]) {
    print("{$computer}: Need run\n");
    $ip = $ip_prefix . (int)$computer;
    $ret = shell_exec("/bin/ping -c 2 -i 0.5 -q {$ip} > /dev/null;echo $?");
    $to_format = trim($ret);
    print("{$computer}: {$ip} {$to_format}\n");
    if ($to_format == '1') {
      print("---> FORMAT\n");
      $last_run[$computer] = $now;
      for ($disk = 1; $disk <= $num_disk; $disk++) {
        shell_exec("{$losetup} -o 1048576 {$lodevice} {$directory}/{$prefix}{$computer}e{$disk}.img\n");
        shell_exec("{$mkfs} {$lodevice}\n");
        sleep(1);
        shell_exec("{$losetup} -d {$lodevice}\n");
      }
    }
  }
}
$fh = fopen($run_file, 'w');
fwrite($fh, "<?php\n\$last_run = array(\n");
foreach ($computers as $computer) {
  fwrite($fh, "  '{$computer}' => {$last_run[$computer]},\n");
}
fwrite($fh, ");\n");
fclose($fh);
