#!/bin/dash
# wicd php gui - shellscript backend
# 22.10.2019 - 26.10.2019
# Command stack: dash wicd-cli which tail cat grep tr ifconfig sed iwconfig

# Settings
WICD_CLI='wicd-cli'
WICD_STATUS_COMMAND='/etc/init.d/wicd'
WICD_SETTINGS='/etc/wicd/manager-settings.conf'
WICD_SAVED_APS='/etc/wicd/wireless-settings.conf'

# helpers
print_S1()
{
	echo -n "$1"
}
print_S4()
{
	echo -n "$4"
}

case $1 in
	'wicd')
		case $2 in
			# body.php wicd status check
			'checkDaemon')
				${WICD_STATUS_COMMAND} status > /dev/null 2>&1 && echo -n 'true' || echo -n 'false'
			;;
			'checkWicdCli')
				which $WICD_CLI > /dev/null 2>&1 && echo -n 'true' || echo -n 'false'
			;;

			# settings
			'setWifiDevice')
				eval $(cat ${WICD_SETTINGS} | grep 'wireless_interface = ' | tr -d ' ')
				sed -i 's/wireless_interface = '"${wireless_interface}"'/wireless_interface = '"${3}"'/g' ${WICD_SETTINGS}
				${WICD_STATUS_COMMAND} reload > /dev/null 2>&1
				echo -n 'true';
			;;
			'getWifiDevice')
				eval $(cat ${WICD_SETTINGS} | grep 'wireless_interface = ' | tr -d ' ')
				echo -n "$wireless_interface"
			;;

			# add network window
			'saveNetwork')
				$WICD_CLI --wireless -l | tail -n +2 | while read line; do
					if [ "$(print_S4 $line)" = "$3" ]; then
						$WICD_CLI --wireless --network $(print_S1 $line) --network-property key --set-to "$4" > /dev/null 2>&1
						$WICD_CLI --wireless --network $(print_S1 $line) --connect > /dev/null 2>&1
						break
					fi
				done
			;;

			#main window buttons
			'disconnect')
				$WICD_CLI --wireless --disconnect
			;;

			# network switches
			'connect')
				$WICD_CLI --wireless -l | tail -n +2 | while read line; do
					if [ "$(print_S4 $line)" = "$3" ]; then
						$WICD_CLI --wireless --network $(print_S1 $line) --connect 2>&1
						break
					fi
				done
			;;
			'setAutoconnect')
				${5}wicd-config-injection.sh "${WICD_SAVED_APS}" "${WICD_SAVED_APS}" "${WICD_STATUS_COMMAND}" renameAutomaticValue "$3" automatic "$4"
			;;

			# main window networks list
			'checkWifiDevice')
				eval $(cat ${WICD_SETTINGS} | grep 'wireless_interface = ' | tr -d ' ')
				if ifconfig -a | grep "$wireless_interface" > /dev/null 2>&1; then
					echo -n 'true'
				else
					echo -n 'false'
				fi
			;;
			'getNetworkList')
				getNetworkListQuery()
				{
					local essid="${2}"
					local mac="${4}"
					local encryption="${9}"
					local quality="${11}"
					local channel="${15}"
					echo "${essid}|${mac}|${encryption}|${quality}|${channel}"
				}

				$WICD_CLI --wireless -S # scan
				$WICD_CLI --wireless -l | tail -n +2 | while read line; do # get
					getNetworkListQuery $($WICD_CLI --wireless -d --network $(print_S1 $line))
				done
			;;
			'isNetworkSaved')
				cat ${WICD_SAVED_APS} | grep -F '['"$3"']' > /dev/null 2>&1 && echo -n 'true' || echo -n 'false'
			;;
			'getAutoconnect')
				${4}wicd-config-injection.sh "${WICD_SAVED_APS}" "${WICD_SAVED_APS}" "${WICD_STATUS_COMMAND}" checkAutomaticValue "$3" automatic true
			;;

			# main window status info
			'getConnectionStatus')
				# Check if wifi card connected
				eval $(cat ${WICD_SETTINGS} | grep 'wireless_interface = ' | tr -d ' ')
				if ! ifconfig -a | grep "$wireless_interface" > /dev/null 2>&1; then
					exit 0
				fi

				# Check if wicd running
				${WICD_STATUS_COMMAND} status > /dev/null 2>&1 || exit 0

				# must wait
				sleep 1

				eval $(cat ${WICD_SETTINGS} | grep 'wireless_interface = ' | tr -d ' ')

				wifi_iwconfig=$(iwconfig $wireless_interface)
				connected_essid_value=$(print_S4 $wifi_iwconfig | tr -d '"')
				connected_essid=${connected_essid_value#*:}

				connected_essid=$(echo -n "$connected_essid" | tr '<' '('); connected_essid=$(echo -n "$connected_essid" | tr '>' ')')
				[ "$connected_essid" = 'off/any' ] && echo -n 'Not connected' || echo -n "Connected to $connected_essid"
			;;
		esac
	;;
esac

exit 0
