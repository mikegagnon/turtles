#~/usr/bin/env bash

shopt -s nocaseglob

path=$1
trash=$2
rootpath=$3

resizedImage=false

if [[ "$path" == *.heic ]]
then
	./process-heic.sh "$path" "$trash"
	resizedImage=true
elif file --mime-type "$path" | grep -q "image/png$";
then
	./process-png.sh "$path" "$trash"
	resizedImage=true
elif [[ "$path" == *.jpg ]]
then
	# We need to avoid infinite loops, so do not resize an image that is already resized
	if [[ "$path" != *.resized.jpg ]]
	then
		./process-jpg.sh "$path" "$trash"
		resizedImage=true
	fi
elif [[ "$path" == *.DS_Store ]]
then
	# Ignore these silly files
	exit 0
else
	echo UNHANDLED "$path"
fi

if [ "$resizedImage" = true ]
then
	# TODO? only run php if an image operation was actually performed
	# TODO: add a batch-mode option that generates all missing index.html files, etc. Implement by using find to find everything that needs updating, then pipe the result into handle-change.sh
	./run-php.sh "$path" "$rootpath"
fi
