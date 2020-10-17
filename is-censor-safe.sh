#!/usr/bin/env bash
#set -x

rootpath=`grealpath $1`

find "$rootpath" | grep "x$" | xargs -I{} ./z-exists.sh {}

exit $?