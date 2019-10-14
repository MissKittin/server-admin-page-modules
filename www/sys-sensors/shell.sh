#!/bin/dash

# Import PATH variable
. ./lib/shell/path.rc

case $1 in
	'sensors')
		sensors  | tail -n +8 | head -n -2
	;;
esac

exit 0
