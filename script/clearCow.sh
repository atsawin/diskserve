#!/bin/sh

/usr/bin/date >&2

cd /space/diskless/cow

cow_size=`blockdev --getsize /dev/loop0`

ietadm --op delete --tid 2 --lun 0
ietadm --op delete --tid 3 --lun 0
ietadm --op delete --tid 4 --lun 0
ietadm --op delete --tid 5 --lun 0

dmsetup remove spice06
dmsetup remove spice07
dmsetup remove spice08
dmsetup remove spice09

losetup -d /dev/loop1
losetup -d /dev/loop2
losetup -d /dev/loop3
losetup -d /dev/loop4

rm spice06.cow
rm spice07.cow
rm spice08.cow
rm spice09.cow

dd if=/dev/zero of=spice06.cow bs=1M count=0 seek=5120
dd if=/dev/zero of=spice07.cow bs=1M count=0 seek=5120
dd if=/dev/zero of=spice08.cow bs=1M count=0 seek=5120
dd if=/dev/zero of=spice09.cow bs=1M count=0 seek=5120

losetup /dev/loop1 spice06.cow
losetup /dev/loop2 spice07.cow
losetup /dev/loop3 spice08.cow
losetup /dev/loop4 spice09.cow

dmsetup create spice06 --table "0 ${cow_size} snapshot /dev/loop0 /dev/loop1 p 64"
dmsetup create spice07 --table "0 ${cow_size} snapshot /dev/loop0 /dev/loop2 p 64"
dmsetup create spice08 --table "0 ${cow_size} snapshot /dev/loop0 /dev/loop3 p 64"
dmsetup create spice09 --table "0 ${cow_size} snapshot /dev/loop0 /dev/loop4 p 64"

ietadm --op new --tid 2 --lun 0 --params Path=/dev/mapper/spice06
ietadm --op new --tid 3 --lun 0 --params Path=/dev/mapper/spice07
ietadm --op new --tid 4 --lun 0 --params Path=/dev/mapper/spice08
ietadm --op new --tid 5 --lun 0 --params Path=/dev/mapper/spice09
