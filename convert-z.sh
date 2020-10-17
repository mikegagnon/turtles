#!/usr/bin/env bash

newrootpath=`grealpath $1`

find "$newrootpath" | grep "z$" | xargs -I{} ./convert-z-instance.sh {} "$newrootpath"
