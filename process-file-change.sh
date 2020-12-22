#!/bin/bash

# For some reason on my system the following shebang creates a bash 
# shell that has a noop for a "shopt -s nocaseglob"
		#!/usr/bin/env bash
# For some reason /bin/bash words. weird

shopt -s nocaseglob

path=$1
trash=$2
rootpath=$3

runphp=false

if [[ "$path" == *.HEIC ]]
then
	echo "."
	echo "."
	echo "."
	echo "."
	echo "."
	echo "."
	echo "."

	./process-heic.sh "$path" "$trash"
	runphp=true
elif file --mime-type "$path" | grep -q "image/png$";
then
	./process-png.sh "$path" "$trash"
	runphp=true
elif [[ "$path" == *.jpg ]]
then
	# We need to avoid infinite loops, so do not resize an image that is already resized
	if [[ "$path" != *.resized.jpg ]]
	then
		./process-jpg.sh "$path" "$trash"
		runphp=true
	fi
elif [[ "$path" == *.DS_Store ]]
then
	# Ignore these silly files
	exit 0
elif [[ "$path" == */link.txt ]]
then
	runphp=true
else
	echo UNHANDLED "$path"
fi

if [ "$runphp" = true ]
then
	# TODO? only run php if an image operation was actually performed
	# TODO: add a batch-mode option that generates all missing index.html files, etc. Implement by using find to find everything that needs updating, then pipe the result into handle-change.sh
	./run-php.sh "$path" "$rootpath"

	# Cannot run hash automatically?
	p=`dirname "$rootpath"`
	#./hash.sh "$p"
	
fi
