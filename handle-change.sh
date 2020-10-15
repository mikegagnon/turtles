#~/usr/bin/env bash

trash=$1
rootpath=$2

# Note: if a filename changes, we will receive the old path and the new path, as separete stdin-lines
# Therefore, we can simply ignore paths that don't exist, because they've either been deleted, or renamed
while IFS='$\n' read -r path; do
    ./process-change.sh "$path" "$trash" "$rootpath"

    bname="$(basename $path)"
    echo "asdf" $bname

    # TODO?: just touch a jpg in the parent directory or something like that?
    if [ "$bname" != "dir-main" ]; then
    	if [ -d "${path}" ] ; then
		    #echo "$path is a directory";
		    parentdir="$(dirname "$path")"
		else
		    parentdir="$(dirname "$path")"
		    parentdir="$(dirname "$parentdir")"
		fi

	    # Must process the parent directory so it updates too
	    echo $path
	    echo $parentdir
	    ./process-change.sh "$parentdir" "$trash" "$rootpath"
	fi



done
