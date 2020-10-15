#~/usr/bin/env bash

rootpath=$1

fswatch --recursive "$rootpath/dir-main" | ./handle-change.sh "$rootpath/trash" "$rootpath/dir-main"
