#!/usr/bin/env bash

path=$1
rootpath=$2

echo "path:"  $path
echo "rootpath" $rootpath

totaldepth=`awk -F"/" '{print NF-1}' <<< "$path"`
rootdepth=`awk -F"/" '{print NF-1}' <<< "$rootpath"`
reldepth=`expr $totaldepth - $rootdepth`
dir=`dirname "$path"`
relpath=`grealpath --relative-to="$rootpath" "$dir"`

cp "index.php" "$dir"
cd "$dir"
php index.php "$relpath" $reldepth > index.html
rm index.php
