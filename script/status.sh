#!/bin/sh

echo "<h2>ietd</h2>"
cat /proc/net/iet/volume
echo
echo "<h2>CoW</h2>"
/sbin/dmsetup status | sort
echo
echo "<h2>Loopback</h2>"
/sbin/losetup -a
echo
echo "<h2>Load</h2>"
/usr/bin/uptime
echo
echo "<h2>Memory</h2>"
/usr/bin/free
echo
echo "<h2>Disk</h2>"
/usr/bin/df
echo
echo "<h2>LAN</h2>"
/sbin/ifconfig
