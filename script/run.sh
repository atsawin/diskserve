#!/bin/sh

/usr/bin/date >&2

cd /etc
rm dhcpd.conf
ln -s dhcpd-run.conf dhcpd.conf
killall -v dhcpd
/usr/sbin/dhcpd
