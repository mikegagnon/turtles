#!/usr/bin/env bash

path=$1
rootpath=$2

totaldepth=`awk -F"/" '{print NF-1}' <<< "$path"`
rootdepth=`awk -F"/" '{print NF-1}' <<< "$rootpath"`
reldepth=`expr $totaldepth - $rootdepth`
dir=`dirname "$path"`
relpath=`grealpath --relative-to="$rootpath" "$dir"`

cp "index.php" "$dir"
#cp "compile-index.py" "$dir"
cd "$dir"
php index.php "$relpath" $reldepth > index.html
#python3 compile-index.py "$relpath" $reldepth > index.json
rm index.php
#rm compile-index.py
