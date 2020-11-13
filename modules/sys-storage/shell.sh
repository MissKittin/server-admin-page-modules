#!/bin/dash
# Command stack: dash, df, free

# Import PATH variable
. ./lib/shell/path.rc

case $1 in
	'disk_usage') df ;;
	'ram_usage') free ;;
esac

exit 0
