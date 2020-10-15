#~/usr/bin/env bash

trash=$1
rootpath=$2

# Note: if a filename changes, we will receive the old path and the new path, as separete stdin-lines
# Therefore, we can simply ignore paths that don't exist, because they've either been deleted, or renamed
while IFS='$\n' read -r path; do
    ./process-change.sh "$path" "$trash" "$rootpath"
done
