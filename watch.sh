#~/usr/bin/env bash

rootpath=$1

fswatch --recursive "$rootpath/contents" | ./handle-change.sh "$rootpath/trash" "$rootpath/contents"
