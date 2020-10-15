#~/usr/bin/env bash

rootpath=$1

fswatch --recursive "$rootpath/dir-contents" | ./handle-change.sh "$rootpath/trash" "$rootpath/dir-contents"
