#!/usr/bin/env bash

rootpath=`grealpath $1`
destpath="$rootpath-censored"

if ./is-censor-safe.sh "$rootpath"; then
	cp -r "$rootpath" "$destpath"
	./convert-z.sh "$destpath"
	find "$destpath" | grep ".DS_Store$" | xargs -I{} rm {}
else
	echo "Aborting ./censor.sh"
	exit 1
fi
