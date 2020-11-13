#!/bin/dash
# Command stack: dash, sensors, tail, head

# Import PATH variable
if [ -e ./lib/shell/path.rc ]; then
	. ./lib/shell/path.rc
else
	. ../lib/shell/path.rc
fi

case $1 in
	'sensors')
		sensors
	;;
esac

exit 0
