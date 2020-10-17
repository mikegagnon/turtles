#!/usr/bin/env bash

path=$1

if test -d "$path/../z"; then
    exit 0 #echo "$FILE exists."
else
	echo "Missing z/ for $path"
	exit 1
fi
