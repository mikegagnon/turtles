#!/usr/bin/env bash
#set -x

rootpath=`grealpath $1`
destpath="$rootpath-censored"

if test -d "$destpath"; then
	>&2 echo "already exists: $destpath"
    exit 1
elif test -f "$destpath"; then
	>&2 echo "already exists: $destpath"
	exit 1
fi

find "$rootpath" | grep "x$" | xargs -I{} ./z-exists.sh {}

exit $?