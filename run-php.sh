#!/usr/bin/env bash

path=$1
rootpath=$2

#echo "rootpath = $rootpath"

totaldepth=`awk -F"/" '{print NF-1}' <<< "$path"`
rootdepth=`awk -F"/" '{print NF-1}' <<< "$rootpath"`
reldepth=`expr $totaldepth - $rootdepth`

#echo "rel depth = $reldepth for $path"

dir=`dirname "$path"`

echo dir "$dir"

cp "index.php" "$dir"
cd "$dir"
#for i in *; do mv "$i" "$(echo $i|tr A-Z a-z)"; done
php index.php $reldepth > index.html