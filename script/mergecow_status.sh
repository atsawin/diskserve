#!/bin/sh

# Purpose:
#   Merge cow from specified computer to master image. Must run after stop iscsi/dm/lo.
# Usage:
#   mergecow.sh <image_path> <cluster_name> <image_loop_name> <cow_path> <computer_name> <cow_loop_name>

IMAGE_PATH=$1
CLUSTER_NAME=$2
IMAGE_LOOP_NAME=$3
COW_PATH=$4
COMPUTER_NAME=$5
COW_LOOP_NAME=$6

date >> /tmp/a
echo Merge Cow Status >> /tmp/a
echo $IMAGE_PATH >> /tmp/a
echo $CLUSTER_NAME >> /tmp/a
echo $IMAGE_LOOP_NAME >> /tmp/a
echo $COW_PATH >> /tmp/a
echo $COMPUTER_NAME >> /tmp/a
echo $COW_LOOP_NAME >> /tmp/a

PROGRESS=`dmsetup status $COMPUTER_NAME`
echo $PROGRESS >> /tmp/a
echo $PROGRESS
