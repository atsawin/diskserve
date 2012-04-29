#!/bin/sh

/etc/rc.d/init.d/dhcp stop
/etc/rc.d/init.d/dhcp start
/etc/rc.d/init.d/iet stop
/etc/rc.d/init.d/iet start
