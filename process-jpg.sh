#!/usr/bin/env bash

path=$1
trash=$2
newname="$path.resized.jpg"

magick convert -resize '1000' "$path" "$newname"
mv "$path" "$trash"
#echo "Resize .jpg: $newname"
tesseract "$newname" "$newname"
