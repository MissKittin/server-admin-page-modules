#!/bin/dash

# Import PATH variable
. ./lib/shell/path.rc

case $1 in
	'suspend')
		sleep 5
		nohup acpid-suspend.sh > /dev/null 2>&1 &
	;;
esac

exit 0
