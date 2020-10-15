#~/usr/bin/env bash
#set -x 

path=$1
trash=$2
newname="$path.resized.jpg"

# We need to avoid infinite loops, so do not resize an image that is already resized
if [[ $path == *.resized.jpg ]]
then
	exit 0
fi

magick convert -resize '1000' "$path" "$newname"
mv "$path" "$trash"
echo "Resize .jpg: $newname"
