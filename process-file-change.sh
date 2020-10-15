#~/usr/bin/env bash

shopt -s nocaseglob

path=$1
trash=$2

if [[ $path == *.heic ]]
then
	./process-heic.sh "$path" "$trash"
#elif [[ $path == *.png ]]
elif file --mime-type "$path" | grep -q "image/png$";
then
	./process-png.sh "$path" "$trash"
elif [[ $path == *.jpg ]]
then
	./process-jpg.sh "$path" "$trash"
elif [[ $path == *.DS_Store ]]
then
	# Ignore these silly files
	exit 0
else
	echo UNHANDLED "$path"
fi
