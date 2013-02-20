#!/bin/sh

# Purpose:
#   Delete variation startup file.
# Usage:
#   deletevariation.sh <cow_path> <variation_file>

COW_PATH=$1
VARIATION_FILE=$2

date >> /tmp/a
echo Delete Variation >> /tmp/a
echo $COW_PATH >> /tmp/a
echo $VARIATION_FILE >> /tmp/a

rm ${COW_PATH}/variation/${VARIATION_FILE}.cow
