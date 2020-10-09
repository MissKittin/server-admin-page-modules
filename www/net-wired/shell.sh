#!/usr/local/share/router/webadmin/share/webadmin/lib/shell/superuser.sh /bin/dash
#?php has_superuser_shebang
# Command stack: dash, readlink, ethtool, grep, cat, sed, ifup, ifconfig, ifdown, sed

# Settings
INTERFACES_CONFIG='/etc/network/interfaces.d'

# Import PATH variable
. ./lib/shell/path.rc

# Import networks
. $(firewall.sh where-are-you)/networks.rc

print_S2()
{
	echo -n "$2"
}

# No links are allowed
INTERFACES_CONFIG_WAN=$(readlink -f "${INTERFACES_CONFIG}/${WAN}")

case $1 in
	'info')
		ethtool $WAN | grep 'Link detected: yes' > /dev/null 2>&1 && echo 'Link detected: yes<br>' || echo 'Link detected: no<br>'
		echo -n 'Connected: '; ifconfig | grep $WAN > /dev/null 2>&1 && echo 'yes<br>' || echo 'no<br>'
	;;
	'get_onBoot')
		cat ${INTERFACES_CONFIG_WAN} | grep "auto $WAN" > /dev/null 2>&1 && echo -n 'checked="checked"'
	;;
	'set_onBoot')
		case $2 in
			'yes')
				sed -i 's/'"$WAN"'/auto '"$WAN"'/g' ${INTERFACES_CONFIG_WAN}
			;;
			'no')
				sed -i 's/auto '"$WAN"'/'"$WAN"'/g' ${INTERFACES_CONFIG_WAN}
			;;
		esac
	;;
	'connect')
		ifup $WAN
	;;
	'disconnect')
		ifconfig $WAN 0.0.0.0 up
		ifdown $WAN
	;;
	'get_static')
		case $2 in
			'enabled')
				cat ${INTERFACES_CONFIG_WAN} | grep -v '#' | grep 'iface '"$WAN"' inet static' > /dev/null 2>&1 && echo -n 'checked="checked"'
			;;
			'address')
				case $3 in
					'ip')
						print_S2 $(cat ${INTERFACES_CONFIG_WAN} | grep 'address')
					;;
					'mask')
						print_S2 $(cat ${INTERFACES_CONFIG_WAN} | grep 'netmask')
					;;
					'gateway')
						print_S2 $(cat ${INTERFACES_CONFIG_WAN} | grep 'gateway')
					;;
				esac
			;;
		esac
	;;
	'set_static')
		case $2 in
			'enable')
				if cat ${INTERFACES_CONFIG_WAN} | grep -v '#' | grep 'iface '"$WAN"' inet static' > /dev/null 2>&1; then
					echo -n '' # no action
				else
					sed -i 's/iface '"$WAN"' inet dhcp/#iface '"$WAN"' inet dhcp/g' ${INTERFACES_CONFIG_WAN}
					sed -i 's/#iface '"$WAN"' inet static/iface '"$WAN"' inet static/g' ${INTERFACES_CONFIG_WAN}
				fi
			;;
			'disable')
				cat ${INTERFACES_CONFIG_WAN} | grep -v '#' | grep 'iface '"$WAN"' inet static' > /dev/null 2>&1 || exit 0

				sed -i 's/#iface '"$WAN"' inet dhcp/iface '"$WAN"' inet dhcp/g' ${INTERFACES_CONFIG_WAN}
				sed -i 's/iface '"$WAN"' inet static/#iface '"$WAN"' inet static/g' ${INTERFACES_CONFIG_WAN}

				address=$(print_S2 $(cat ${INTERFACES_CONFIG_WAN} | grep 'address'))
				sed -i 's/address '"$address"'/#address '"$address"'/g' ${INTERFACES_CONFIG_WAN}
				mask=$(print_S2 $(cat ${INTERFACES_CONFIG_WAN} | grep 'netmask'))
				sed -i 's/netmask '"$mask"'/#netmask '"$mask"'/g' ${INTERFACES_CONFIG_WAN}
				gateway=$(print_S2 $(cat ${INTERFACES_CONFIG_WAN} | grep 'gateway'))
				sed -i 's/gateway '"$gateway"'/#gateway '"$gateway"'/g' ${INTERFACES_CONFIG_WAN}
			;;
			'address')
				case $3 in
					'ip')
						address=$(print_S2 $(cat ${INTERFACES_CONFIG_WAN} | grep 'address'))
						cat ${INTERFACES_CONFIG_WAN} | grep -v '#' | grep 'address' > /dev/null 2>&1 && sed -i 's/address '"$address"'/address '"$4"'/g' ${INTERFACES_CONFIG_WAN} || sed -i 's/#address '"$address"'/address '"$4"'/g' ${INTERFACES_CONFIG_WAN}
					;;
					'mask')
						mask=$(print_S2 $(cat ${INTERFACES_CONFIG_WAN} | grep 'netmask'))
						cat ${INTERFACES_CONFIG_WAN} | grep -v '#' | grep 'netmask' > /dev/null 2>&1 && sed -i 's/netmask '"$mask"'/netmask '"$4"'/g' ${INTERFACES_CONFIG_WAN} || sed -i 's/#netmask '"$mask"'/netmask '"$4"'/g' ${INTERFACES_CONFIG_WAN}
					;;
					'gateway')
						gateway=$(print_S2 $(cat ${INTERFACES_CONFIG_WAN} | grep 'gateway'))
						cat ${INTERFACES_CONFIG_WAN} | grep -v '#' | grep 'gateway' > /dev/null 2>&1 && sed -i 's/gateway '"$gateway"'/gateway '"$4"'/g' ${INTERFACES_CONFIG_WAN} || sed -i 's/#gateway '"$gateway"'/gateway '"$4"'/g' ${INTERFACES_CONFIG_WAN}
					;;
				esac
			;;
		esac
	;;
esac

exit 0
