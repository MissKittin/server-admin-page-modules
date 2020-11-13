#!/usr/local/share/router/webadmin/share/webadmin/lib/shell/superuser.sh /bin/dash
#?php has_superuser_shebang
# Command stack: dash, apt-get, apt-check, stat

# Import PATH variable
if [ -e ./lib/shell/path.rc ]; then
	. ./lib/shell/path.rc
else
	. ../lib/shell/path.rc
fi

case $1 in
	'apt-update')
		apt-get update 2>&1
		echo; apt-check -h -c -f 2>&1
	;;
	'updates')
		apt-check -h -c -f 2>&1
	;;
	'last-update')
		stat --format=%y /var/cache/apt/pkgcache.bin
	;;
	'system-eol')
		# Get it from notify-daemon
		home_dir=`notify-daemon.sh print-home-dir`
		. $home_dir/events.rc.d/eol.rc
		echo -n "$eol__timestamp"
	;;
esac

exit 0
