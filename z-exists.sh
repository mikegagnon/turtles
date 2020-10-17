#!/usr/bin/env bash

path=$1

if test -d "$path/../z"; then
    exit 0
else
	>&2 echo "Missing z/ for $path"
	exit 1
fi
