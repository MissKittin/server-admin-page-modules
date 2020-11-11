#!/usr/local/share/router/webadmin/share/webadmin/lib/shell/superuser.sh /bin/dash
#?php has_superuser_shebang
# Command stack: dash, timeout

# Import PATH variable
. ./lib/shell/path.rc

# Import daemon status check library
. ./lib/shell/check-service.rc

# Settings
start_stop_timeout=10

# Colors
GREEN='<span style="color: #00aa00;">'
RED='<span style="color: #ff0000;">'

case $1 in
	'user_service')
		case $2 in
			'status')
				$3 $4 $5 $6 $7 $8 $9 > /dev/null 2>&1 && \
					echo -n "${GREEN}Running</span>" || \
					echo -n "${RED}Stopped</span>"
			;;
			*)
				$2 $3 $4 $5 $6 $7 $8 $9
			;;
		esac
	;;
esac

exit 0
