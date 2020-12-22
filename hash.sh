#!/usr/bin/env bash

rootpath=`grealpath $1`
hashpath="$rootpath/hash/*.html"
rm -f $hashpath
python3 hash.py $rootpath 

#./run-php.sh "$path" "$rootpath"


#echo hashing $rootpath

#find . | grep *link.txt
#https://stackoverflow.com/questions/9612090/how-to-loop-through-file-names-returned-by-find
# for i in $(find $rootpath -name "link.txt"); do # Not recommended, will break on whitespace
#     echo "$i"
# done

