#!/usr/local/share/router/webadmin/www/lib/shell/superuser.sh /bin/sh
#?php has_superuser_shebang

case $1 in
	'sync-clock')
		ntpdate-debian
	;;
esac

exit 0
