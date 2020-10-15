#~/usr/bin/env bash

shopt -s nocaseglob

path=$1
trash=$2

if [[ $path == *.heic ]]
then
	./process-heic.sh "$path" "$trash"
else
	echo foo $path
fi
