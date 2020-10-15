#!/usr/bin/env bash

path=$1
rootpath=$2

#echo "rootpath = $rootpath"

totaldepth=`awk -F"/" '{print NF-1}' <<< "$path"`
rootdepth=`awk -F"/" '{print NF-1}' <<< "$rootpath"`
reldepth=`expr $totaldepth - $rootdepth`

#echo "rel depth = $reldepth for $path"

dir=`dirname "$path"`
relpath=`grealpath --relative-to="$rootpath" "$dir"`


echo dir "$dir"

cp "index.php" "$dir"
cd "$dir"
php index.php "$relpath" $reldepth > index.html
