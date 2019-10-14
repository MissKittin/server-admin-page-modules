#!/bin/dash

# Import PATH variable
. ./lib/shell/path.rc

case $1 in
	'get-notifications')
		notify-daemon.sh journal list www
	;;
	'remove-notify')
		notify-daemon.sh journal del $2
	;;
esac

exit 0
