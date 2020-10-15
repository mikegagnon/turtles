#~/usr/bin/env bash

rootpath=`grealpath $1`

echo $rootpath
fswatch -Ee "(html|php|DS_Store|dir-main)$" --recursive "$rootpath/dir-main" | ./handle-change.sh "$rootpath/trash" "$rootpath/dir-main" "$rootpath"
