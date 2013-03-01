#!/bin/sh

# Purpose:
#   Update variation startup file from specific computer.
# Usage:
#   copyvariation.sh <cow_path> <computer_name> <variation_file>

COW_PATH=$1
COMPUTER_NAME=$2
VARIATION_FILE=$3

date >> /tmp/a
echo Copy Variation >> /tmp/a
echo $COW_PATH >> /tmp/a
echo $COMPUTER_NAME >> /tmp/a
echo $VARIATION_FILE >> /tmp/a

mkdir -p ${COW_PATH}/variation
cp -a ${COW_PATH}/${COMPUTER_NAME}.cow ${COW_PATH}/variation/${VARIATION_FILE}.cow
