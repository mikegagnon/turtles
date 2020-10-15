#~/usr/bin/env bash

home=$1
trash=$2

#fswatch --event-flags --recursive $1 | ./handle-change.sh
fswatch --recursive $1 | ./handle-change.sh $2
