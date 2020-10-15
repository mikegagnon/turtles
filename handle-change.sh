#~/usr/bin/env bash
set -x

trash=$1
rootpath=$2
basepath=$3

# Note: if a filename changes, we will receive the old path and the new path, as separete stdin-lines
# Therefore, we can simply ignore paths that don't exist, because they've either been deleted, or renamed
while IFS='$\n' read -r path; do
    ./process-change.sh "$path" "$trash" "$rootpath"

    #bname="$(basename $path)"
    #echo "asdf" $bname

    # TODO?: just touch a jpg in the parent directory or something like that?
 #    if [ "$bname" != "dir-main" ]; then
 #    	if [ -d "${path}" ] ; then
	# 	    #echo "$path is a directory";
	# 	    parentdir="$(dirname "$path")"
	# 	else
	# 	    parentdir="$(dirname "$path")"
	# 	    parentdir="$(dirname "$parentdir")"
	# 	fi

	#     # Must process the parent directory so it updates too
	#     echo "invoking parent, path=$path"
	#     echo "invoking parent, parentdir=$parentdir"
	#     ./process-change.sh "$parentdir" "$trash" "$rootpath"
	# fi

    	if [ -d "${path}" ] ; then
		    #echo "$path is a directory";
		    parentdir="$(dirname "$path")"
		else
		    parentdir="$(dirname "$path")"
		    parentdir="$(dirname "$parentdir")"
		fi

		echo "aaa $parentdir"
		echo "bbbb $basepath"

		if [ "$parentdir" != "$basepath" ]; then
		    # Must process the parent directory so it updates too
		    echo "invoking parent, path=$path"
		    echo "invoking parent, parentdir=$parentdir"
		    ./process-change.sh "$parentdir" "$trash" "$rootpath"
		fi
	#fi



done
