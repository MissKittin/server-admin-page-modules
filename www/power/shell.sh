#!/usr/local/share/router/webadmin/www/lib/shell/superuser.sh /bin/dash
#?php has_superuser_shebang

# Import PATH variable
. ./lib/shell/path.rc

case $1 in
	'suspend')
		sleep 5
		nohup acpid-suspend.sh > /dev/null 2>&1 &
	;;
	'halt')
		halt
	;;
	'reboot')
		reboot
	;;
esac

exit 0
