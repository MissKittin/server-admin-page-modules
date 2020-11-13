#!/usr/local/share/router/webadmin/share/webadmin/lib/shell/superuser.sh /bin/sh
#?php has_superuser_shebang
# Command stack: ntpdate-debian

case $1 in
	'sync-clock')
		ntpdate-debian
	;;
esac

exit 0
