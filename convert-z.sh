#!/usr/bin/env bash
#set -x

newrootpath=`grealpath $1`

find "$newrootpath" | grep "z$" | xargs -I{} ./convert-z-instance.sh {}
