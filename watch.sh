#~/usr/bin/env bash

rootpath=`grealpath $1`

echo $rootpath
fswatch -Ee "(html|php|DS_Store|main)$" --recursive "$rootpath/main" | ./handle-change.sh "$rootpath/trash" "$rootpath/main" "$rootpath"
