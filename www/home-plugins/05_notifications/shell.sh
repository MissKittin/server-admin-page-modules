#!/usr/local/share/router/webadmin/www/lib/shell/superuser.sh /bin/dash
#?php has_superuser_shebang

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
