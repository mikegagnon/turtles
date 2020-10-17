#!/usr/bin/env bash
set -x

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

#ls parentpath/

#find "$rootpath" | grep "z$" | xargs -I{} ./convert-z-instance.sh {}
