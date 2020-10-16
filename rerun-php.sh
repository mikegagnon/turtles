#!/usr/bin/env bash

rootpath=`grealpath $1`
mainpath="$rootpath/main"

find "$mainpath" -type d | xargs -I{}  ./run-php.sh {}/dummy-filename "$mainpath"