#!/usr/bin/env bash

rootpath=`grealpath $1`
destpath="$rootpath-censored"

if ./is-censor-safe.sh "$rootpath"; then
	cp -r "$rootpath" "$destpath"
	./convert-z.sh "$destpath"
else
	echo "Aborting ./censor.sh"
	exit 1
fi
