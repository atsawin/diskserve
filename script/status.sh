#!/bin/sh

echo
echo "::ietd_volume"
timeout 5 cat /proc/net/iet/volume
echo "::ietd_session"
timeout 5 cat /proc/net/iet/session
echo "::cow"
/sbin/dmsetup status | sort
echo "::mapping"
/sbin/dmsetup table | sort
echo "::loopback"
/sbin/losetup -a
echo "::load"
/usr/bin/uptime
echo "::memory"
/usr/bin/free
echo "::disk"
/usr/bin/df
echo "::lan"
/sbin/ifconfig
