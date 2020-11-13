#!/usr/local/share/router/webadmin/share/webadmin/lib/shell/superuser.sh /bin/dash
#?php has_superuser_shebang
# Command stack: dash

# Import PATH variable
. ./lib/shell/path.rc

case $1 in
	'getlog')
		[ -e $2 ] && cat $2 || echo 'Unable to open file!'
	;;
	'superuser')
		$2 $3 $4 $5 $6 $7 $8 $9
	;;
esac

exit 0
