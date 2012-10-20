#!/bin/sh

# Purpose:
#   Clear specified cow while the system is online. Only specified computer must turn off.
#   This is mostly used on booting computer.
# Usage:
#   newcow.sh <computer_name> <tid> <image_path> <image_loop_name> <cow_path> <cow_loop_name> <cow_size>

COMPUTER_NAME=$1
TID=$2
IMAGE_PATH=$3
IMAGE_LOOP_NAME=$4
COW_PATH=$5
COW_LOOP_NAME=$6
COW_SIZE=$7

date >> /tmp/a
echo $COMPUTER_NAME >> /tmp/a
echo $TID >> /tmp/a
echo $IMAGE_PATH >> /tmp/a
echo $IMAGE_LOOP_NAME >> /tmp/a
echo $COW_PATH >> /tmp/a
echo $COW_LOOP_NAME >> /tmp/a
echo $COW_SIZE >> /tmp/a

image_size=`blockdev --getsize $IMAGE_LOOP_NAME`

ietadm --op delete --tid $TID --lun 0
sleep 1.5
dmsetup remove $COMPUTER_NAME
losetup -d $COW_LOOP_NAME
rm ${COW_PATH}/${COMPUTER_NAME}.cow
dd if=/dev/zero of=${COW_PATH}/${COMPUTER_NAME}.cow bs=1M count=0 seek=$COW_SIZE
losetup $COW_LOOP_NAME ${COW_PATH}/${COMPUTER_NAME}.cow
dmsetup create ${COMPUTER_NAME} --table "0 ${image_size} snapshot $IMAGE_LOOP_NAME $COW_LOOP_NAME p 64"
ietadm --op new --tid $TID --lun 0 --params Path=/dev/mapper/${COMPUTER_NAME}
sleep 1.5
