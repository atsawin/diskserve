#!/bin/sh

# Purpose:
#   Clear spceified cow files. Must run after stop iscsi/dm/lo.
# Usage:
#   clearcows.sh <cow_path> <cow_size> <computer_name1> [<computer_name2> [...]]

COW_PATH=$1
COW_SIZE=$2
shift
shift

echo $COW_PATH
echo $COW_SIZE
for computer_name in "$@"; do
  echo $computer_name
  rm ${COW_PATH}/${computer_name}.cow
  dd if=/dev/zero of=${COW_PATH}/${computer_name}.cow bs=1M count=0 seek=$COW_SIZE
done
