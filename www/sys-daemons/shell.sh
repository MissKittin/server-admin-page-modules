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
#	'check_service')
#		timeout $start_stop_timeout /etc/init.d/$2 status > /dev/null 2>&1 && \
#			echo -n "${GREEN}Running</span>" || \
#			echo -n "${RED}Stopped</span>"
#	;;
#	'service')
#		# radvd patch (prevent php server lockdown)
#		if [ $2 = 'radvd' ]; then
#			if [ $3 = 'start' ]; then
#				/etc/init.d/$2 $3 > /dev/null 2>&1 && echo 'radvd started successfully' || echo 'radvd error!'
#			else
#				/etc/init.d/$2 $3 > /dev/null 2>&1 && echo 'radvd stopped' || echo 'radvd error!'
#			fi
#			exit 0
#		fi
#
#		timeout $start_stop_timeout /etc/init.d/$2 $3 2>&1
#	;;
#	'special_service')
#		if [ "$2" = 'xl2tpd' ]; then
#			timeout $start_stop_timeout /etc/init.d/xl2tpd $3 2>&1
#			exit 0
#		fi
#
#		print_S2()
#		{
#			echo -n "$2"
#		}
#		start_stop_service()
#		{
#			timeout $start_stop_timeout $1 $2 2>&1
#		}
#		service_path=$(print_S2 `whereis $2`)
#		start_stop_service $service_path $3
#	;;
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
