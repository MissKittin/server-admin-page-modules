#!/bin/dash

# Import PATH variable
if [ -e ./lib/shell/path.rc ]; then
	. ./lib/shell/path.rc
else
	. ../lib/shell/path.rc
fi

case $1 in
	'sensors')
		sensors  | tail -n +8 | head -n -2
	;;
esac

exit 0
