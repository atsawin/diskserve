#!/bin/sh

timeout 5 cat /proc/net/iet/volume > /tmp/volume-$$
if [ $? = 0 ]; then
  FILESIZE=`stat -c%s /tmp/volume-$$`
  if [ $FILESIZE != 0 ]; then
    mv /tmp/volume-$$ /tmp/volume.cache
  fi
fi
cat /tmp/volume.cache
