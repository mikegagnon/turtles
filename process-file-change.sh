#~/usr/bin/env bash

shopt -s nocaseglob

path=$1
trash=$2

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
	echo "resized"
else
	echo "false"
fi