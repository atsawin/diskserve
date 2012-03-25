#!/bin/sh

# Usage:
#   newcow.sh <computer_name> <tid> <image_loop_name> <cow_loop_name> <cow_size>

COMPUTER_NAME=$1
TID=$2
IMAGE_LOOP_NAME=$3
COW_LOOP_NAME=$4
COW_SIZE=$5

date >> /tmp/a
echo $COMPUTER_NAME >> /tmp/a
echo $TID >> /tmp/a
echo $IMAGE_LOOP_NAME >> /tmp/a
echo $COW_LOOP_NAME >> /tmp/a
echo $COW_SIZE >> /tmp/a

cd /space/diskless

image_size=`blockdev --getsize $IMAGE_LOOP_NAME`

ietadm --op delete --tid $TID --lun 0
dmsetup remove $COMPUTER_NAME
losetup -d $COW_LOOP_NAME
rm ${COMPUTER_NAME}.cow
dd if=/dev/zero of=${COMPUTER_NAME}.cow bs=1M count=0 seek=$COW_SIZE
losetup $COW_LOOP_NAME ${COMPUTER_NAME}.cow
dmsetup create ${COMPUTER_NAME} --table "0 ${image_size} snapshot $IMAGE_LOOP_NAME $COW_LOOP_NAME p 64"
ietadm --op new --tid $TID --lun 0 --params Path=/dev/mapper/${COMPUTER_NAME}
