#!/usr/local/share/router/webadmin/share/webadmin/lib/shell/superuser.sh /bin/dash
#?php has_superuser_shebang
# Command stack: dash, readlink, cat, grep, sed

# Settings
HOSTAPD_CONFFILE='/etc/hostapd/hostapd.conf' # change this
HOSTAPD_RESTART_COMMAND='/etc/init.d/hostapd restart' # change this

# Import PATH variable
. ./lib/shell/path.rc

# No links allowed
HOSTAPD_CONFFILE=$(readlink -f "${HOSTAPD_CONFFILE}")

case $1 in
	'ap')
		case $2 in
			'get')
				case $3 in
					'ssid')
						eval `cat ${HOSTAPD_CONFFILE} | grep ssid=.`
						echo -n "$ssid"
					;;
					'hide-ssid')
						eval `cat ${HOSTAPD_CONFFILE} | grep ignore_broadcast_ssid=.`
						[ "$ignore_broadcast_ssid" = '1' ] && echo -n 'checked="checked"'
					;;
					'mode')
						eval `cat ${HOSTAPD_CONFFILE} | grep hw_mode=.`
						for i in b g n; do
							[ "$hw_mode" = "$i" ] && echo "<option selected>$i</option>" || echo "<option>$i</option>"
						done
					;;
					'channel')
						eval `cat ${HOSTAPD_CONFFILE} | grep channel=.`
						for i in 0 11 12 13 14; do
							if [ "$i" = '0' ]; then
								[ "$channel" = '0' ] && echo "<option selected>auto</option>" || echo "<option>auto</option>"
							else
								[ "$channel" = "$i" ] && echo "<option selected>$i</option>" || echo "<option>$i</option>"
							fi
						done
					;;
				esac
			;;
			'set')
				case $3 in
					'ssid')
						eval `cat ${HOSTAPD_CONFFILE} | grep ssid=.`
						[ "$ssid" = "$4" ] && exit 0
						sed -i 's/ssid='"$ssid"'/ssid='"$4"'/g' ${HOSTAPD_CONFFILE}
					;;
					'password')
						eval `cat ${HOSTAPD_CONFFILE} | grep wpa_passphrase=.`
						[ "$wpa_passphrase" = "$4" ] && exit 0
						sed -i 's/wpa_passphrase='"$wpa_passphrase"'/wpa_passphrase='"$4"'/g' ${HOSTAPD_CONFFILE}
					;;
					'hide-ssid')
						eval `cat ${HOSTAPD_CONFFILE} | grep ignore_broadcast_ssid=.`
						[ "$4" = 'yes' ] && set_ignore_broadcast_ssid='1' || set_ignore_broadcast_ssid='0'
						[ "$ignore_broadcast_ssid" = "set_ignore_broadcast_ssid" ] && exit 0
						sed -i 's/ignore_broadcast_ssid='"$ignore_broadcast_ssid"'/ignore_broadcast_ssid='"$set_ignore_broadcast_ssid"'/g' ${HOSTAPD_CONFFILE}
					;;
					'mode')
						eval `cat ${HOSTAPD_CONFFILE} | grep hw_mode=.`
						[ "$hw_mode" = "$4" ] && exit 0
						sed -i 's/hw_mode='"$hw_mode"'/hw_mode='"$4"'/g' ${HOSTAPD_CONFFILE}
					;;
					'channel')
						eval `cat ${HOSTAPD_CONFFILE} | grep channel=.`
						[ "$4" = 'auto' ] && new_channel='0' || new_channel="$4"
						[ "$channel" = "$new_channel" ] && exit 0
						sed -i 's/channel='"$channel"'/channel='"$new_channel"'/g' ${HOSTAPD_CONFFILE}
					;;
				esac
			;;
			'restart')
				$HOSTAPD_RESTART_COMMAND
			;;
		esac
	;;

esac

exit 0
