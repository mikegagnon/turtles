#!/usr/bin/env bash
#set -x

path=$1
trash=$2
rootpath=$3

if [[ -f  "$path" ]]
then

 #	dirpath=`dirname $path`


 #    #cp touch.sh.template $path/touch.template
 #    echo "."
 #    echo "."
 #    echo "."
 #    echo "."
 #    echo "."
 #    echo "."

 #    cat touch.sh.template | sed s+DEST+$dirpath+g > touch.sh
 #    #mv touch.sh $path/touch.sh
	# echo "."
 #    echo "."
 #    echo "."
 #    echo "."
 #    echo "."
 #    echo "."



    #echo "$path file exists"
    ./process-file-change.sh "$path" "$trash" "$rootpath"
else
    # echo "$path file does NOT exist"
    if [[ -d  "$path" ]]
	then
	    # echo "$path dir exists"
	    # echo "path: $path"
	    # echo "trash: $trash"
	    # echo "rootpath: $rootpath"
	    bname="$(basename $path)"


	 #    #cp touch.sh.template $path/touch.template
	 #    echo "."
	 #    echo "."
	 #    echo "."
	 #    echo "."
	 #    echo "."
	 #    echo "."

	 #    cat touch.sh.template | sed s+DEST+$path+g > touch.sh
	 #    #mv touch.sh $path/touch.sh
		# echo "."
	 #    echo "."
	 #    echo "."
	 #    echo "."
	 #    echo "."
	 #    echo "."
	    

	    if [ "$bname" = "x" ]; then
		 	cp "$path/../"*.resized.jpg "$path/x.jpg"
		fi

	    ./process-dir-change.sh "$path" "$trash" "$rootpath"
	else
		:
	 	# This happens when a directory or filename changes name, or is deleted.
	 	# In which case, we can simply ignore the path, because it is now irrelevant
	    #echo "$path file does NOT exist, and dir does NOT exist"
	fi
fi

