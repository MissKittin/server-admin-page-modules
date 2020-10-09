#!/bin/dash
# Command stack: dash, readlink, tr, wicd-cli, cat, grep, ifconfig, touch, rm

# Settings
WICD_SAVED_APS='/etc/wicd/wireless-settings.conf'
WICD_SETTINGS='/etc/wicd/manager-settings.conf'
WICD_STATUS_COMMAND='/etc/init.d/wicd'

# Import PATH variable
if [ -e ../lib/shell/path.rc ]; then
	. ../lib/shell/path.rc
else
	. ./lib/shell/path.rc
fi

# Import interfaces library
if [ -e ../lib/shell/list-interfaces.rc ]; then
	. ../lib/shell/list-interfaces.rc
else
	. ./lib/shell/list-interfaces.rc
fi

# No links are allowed
WICD_SAVED_APS=$(readlink -f "${WICD_SAVED_APS}")
WICD_SETTINGS=$(readlink -f "${WICD_SETTINGS}")

case $1 in
	'wifi')
		case $2 in
			'list-aps')
				# Exec trip:
				# main -> parse_list_networks() -> list_range() -> print_S2()
				#				-> buttons_add_connect()

				# helper
				print_S2()
				{
					echo -n "$2"
				}

				# AP config
				print_S12()
				{
					echo -n "${12}" | tr '[:lower:]' '[:upper:]'
				}
				ap_ifconfig=$($0 interfaces wifi 2>/dev/null)
				ap_mac=`print_S12 $ap_ifconfig`

				# Parser
				buttons_add_connect()
				{
					if cat ${WICD_SAVED_APS} | grep "$2" > /dev/null 2>&1; then
						echo -n '<td><button class="system_button" name="connect" type="submit" value="'"$1"'">Connect</button></td>'
					else
						echo '<td><button class="system_button" name="add" type="submit" value="'"$1"'">Add</button></td><td><input type="password" name="password" id="password" required></td>'
					fi
				}
				# display icon
				list_range()
				{
					value=`wicd-cli --wireless --network $1 --network-details  | grep 'Quality: '`
					range=`print_S2 $value`

					if [ "$range" -le '50' ]; then
						echo -n '<img src="'"$icons_location"'/range_0.png" alt="range">'
					elif [ "$range" -le '60' ]; then
						echo -n '<img src="'"$icons_location"'/range_1.png" alt="range">'
					elif [ "$range" -le '70' ]; then
						echo -n '<img src="'"$icons_location"'/range_2.png" alt="range">'
					elif [ "$range" -le '80' ]; then
						echo -n '<img src="'"$icons_location"'/range_3.png" alt="range">'
					elif [ "$range" -le '90' ]; then
						echo -n '<img src="'"$icons_location"'/range_4.png" alt="range">'
					elif [ "$range" -gt '90' ]; then
						echo -n '<img src="'"$icons_location"'/range_5.png" alt="range">'
					fi
				}
				# print table row
				parse_list_networks()
				{
					[ "$1" = '#' ] && return
					[ "$2" = "$ap_mac" ] && return
					[ "$4" = '<hidden>' ] && name="(hidden)" || name="$4"
					rm /tmp/.web_shell_no_wifi_networks

					echo "<tr>
						<td>$name</td>
						<td>$2</td>
						<td>$3</td>
						<td>`list_range $1`</td>
						`buttons_add_connect $1 $2`
					</tr>"
				}

				# Check if wifi card connected
				eval `cat ${WICD_SETTINGS} | grep 'wireless_interface = ' | tr -d ' '`
				if ! ifconfig -a | grep "$wireless_interface" > /dev/null 2>&1; then
					echo '<tr>
						<td colspan="4">
							<span style="color: #aa0000;">WiFi card not connected</span>
						</td>
					</tr>'
					exit 0
				fi

				# DO!
				icons_location="$3" # for list_range()
				touch /tmp/.web_shell_no_wifi_networks
				wicd-cli --wireless --scan --list-networks | while read line; do
					case $line in
						'Error: Could not connect to the daemon. Please make sure it is running.')
							echo '<tr>
								<td colspan="4">
									<span style="color: #aa0000;">wicd daemon not running</span>
								</td>
							</tr>'
							rm /tmp/.web_shell_no_wifi_networks
							break
						;;
					esac
					parse_list_networks $line
				done
				[ -e /tmp/.web_shell_no_wifi_networks ] && \
					echo '<tr><td colspan="4">No networks available</td></tr>' && \
					rm /tmp/.web_shell_no_wifi_networks
			;;
			'add')
				[ "$3" = '' ] && exit 1
				[ "$4" = '' ] && exit 1

				wicd-cli --wireless --network $3 --network-property key --set-to $4
				wicd-cli --wireless --network $3 --connect
			;;
			'connect')
				[ "$3" = '' ] && exit 1
				wicd-cli --wireless --network $3 --connect
			;;
			'disconnect')
				wicd-cli --wireless --disconnect
			;;
			'print-connected')
				# Check if wifi card connected
				eval `cat ${WICD_SETTINGS} | grep 'wireless_interface = ' | tr -d ' '`
				if ! ifconfig -a | grep "$wireless_interface" > /dev/null 2>&1; then
					exit 1
				fi

				# Check if wicd running
				${WICD_STATUS_COMMAND} status > /dev/null 2>&1 || exit 1

				# must wait
				sleep 1

				eval `cat ${WICD_SETTINGS} | grep 'wireless_interface = ' | tr -d ' '`
				print_S4()
				{
					echo -n "$4"
				}
				wifi_iwconfig=`iwconfig $wireless_interface`
				connected_essid_value=`print_S4 $wifi_iwconfig | tr -d '"'`
				connected_essid=${connected_essid_value#*:}

				[ "$connected_essid" = 'off/any' ] && message='Not connected' || message="Connected to $connected_essid"
				echo -n "$message"
			;;
		esac
	;;
esac

exit 0
