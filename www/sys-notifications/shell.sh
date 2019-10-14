#!/bin/dash

# Import PATH variable
. ./lib/shell/path.rc

# Import daemon status check library
. ./lib/shell/check-service.rc

case $1 in
	'notify-daemon-settings')
		case $2 in
			'print')
				notify-daemon-state.sh www $3
			;;
			'status')
				exec $0 check_special_service notify-daemon.sh
			;;
			'set')
				home_dir=`notify-daemon.sh print-home-dir`
				case $3 in
					'enable')
						case $4 in
							'event')
								cd $home_dir/events.rc.d
								mv $5 ${5%.disabled*}
							;;
							'critical-event')
								cd $home_dir/critical-events.rc.d
								mv $5 ${5%.disabled*}
							;;
							'sender-config')
								. $home_dir/sender_config.rc.d/$5
								name_search=`set | grep '__enabled='`
								name="\$${name_search%__*}__enabled"
								value=`eval echo -n "$name"`

								[ "$value" = 'true' ] && exit 0
								name=`echo -n "$name" | sed 's/\\$//g'`
								sed -i 's/'"$name"'='"'"'false'"'"'/'"$name"'='"'"'true'"'"'/g' $home_dir/sender_config.rc.d/$5
							;;
							'sender-manually')
								cd $home_dir/sender.rc.d
								mv $5 ${5%.disabled*}
							;;
						esac
					;;
					'disable')
						case $4 in
							'event')
								cd $home_dir/events.rc.d
								mv $5 ${5}.disabled
							;;
							'critical-event')
								cd $home_dir/critical-events.rc.d
								mv $5 ${5}.disabled
							;;
							'sender-manually')
								cd $home_dir/sender.rc.d
								mv $5 ${5}.disabled
							;;
						esac
					;;
				esac
			;;
		esac
	;;
esac

exit 0
