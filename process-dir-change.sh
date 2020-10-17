#!/usr/bin/env bash

shopt -s nocaseglob

path="$1/dummy-filename"
trash=$2
rootpath=$3

touch "$1/link.txt"
./run-php.sh "$path" "$rootpath"
