#!/usr/bin/env bash

newrootpath=`grealpath "$2"`

# TODO: put quotes around $1 for every grealpath?
zpath=`grealpath "$1"`
zjpg=`ls -1 "$zpath/"*.jpg | head -n 1`
parentpath=`grealpath "$zpath"/..`
xpath=`grealpath "$parentpath"/x`
targetjpg=`ls -1 "$parentpath/"*.resized.jpg | head -n 1`
cp "$zjpg" "$targetjpg"

rm "$zpath"/*
rmdir "$zpath"
rm "$xpath"/*
rmdir "$xpath"
rm "$parentpath"/*.txt

tesseract "$targetjpg" "$targetjpg"


#ls parentpath/

#find "$rootpath" | grep "z$" | xargs -I{} ./convert-z-instance.sh {}

path="$targetjpg"
rootpath="$newrootpath"

echo "path:"  $path
echo "newrootpath" $rootpath

totaldepth=`awk -F"/" '{print NF-1}' <<< "$path"`
rootdepth=`awk -F"/" '{print NF-1}' <<< "$rootpath"`

# NOTICE: the -1 here differs from ./run-php.sh
# because in ./run-php.sh the "main/" is excluded from $path
# but here, "main/" is included in $path
reldepth=`expr $totaldepth - $rootdepth - 1` 
dir=`dirname "$path"`
echo "dir: " $dir
relpath=`grealpath --relative-to="$rootpath" "$dir"`

cp "index.php" "$dir"
cd "$dir"
set -x
php index.php "$relpath" $reldepth > index.html
rm index.php
