#~/usr/bin/env bash

rootpath=$1
trash=$2

fswatch --recursive "$rootpath" | ./handle-change.sh "$trash" "$rootpath"
