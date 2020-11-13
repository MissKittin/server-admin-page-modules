#!/usr/local/share/router/webadmin/share/webadmin/lib/shell/superuser.sh /bin/dash
#?php has_superuser_shebang
# Command stack: dash, ls, dirname, sed, cat

# Data provider - OS backend
# This script don't need superuser, but scripts in /usr/local/sbin may need root

# Import PATH variable
. ../lib/shell/path.rc

case $1 in
	'queryInterfaces')
		[ "$2" = '' ] && exit 0
		interfaces=$(echo "${@}" | sed 's/queryInterfaces //g') # arg filter

		# RX/TX to B/s converter
		interfaceUtilization()
		{
			# input: $interface
			# output: Received $1 B/s Sent $2 B/s
			# source: https://stackoverflow.com/a/17102611

			if [ ! -e "/sys/class/net/${1}" ]; then
				# Interface not exists, abort
				echo -n 'null|null'
				return 1
			fi
			RXPREV='-1'
			TXPREV='-1'
			while true; do
				RX=$(cat /sys/class/net/${1}/statistics/rx_bytes)
				TX=$(cat /sys/class/net/${1}/statistics/tx_bytes)
				case ${RXPREV} in
					'-1')
						RXPREV="${RX}"
						TXPREV="${TX}"
					;;
					*)
						BWRX=$((${RX}-${RXPREV}))
						BWTX=$((${TX}-${TXPREV}))
						echo -n "${BWRX}|${BWTX}"
						break
					;;
				esac
				sleep 0.1
			done
		}

		# Run converter in loop
		for i in ${interfaces}; do
			echo "$(interfaceUtilization ${i})" # B/s B/s (array delimiter in function)
		done

		exit 0
	;;
	'getInterfaces')
		print_S9(){ echo -n "${9} "; } # no awk

		# Read interfaces from system
		ls -l /sys/class/net/ | grep -v '../../devices/virtual/' | while read line; do
			[ "$(print_S9 ${line})" = ' ' ] || print_S9 ${line}
		done

		# Read custom interfaces
		[ -e "$(dirname "$(readlink -f "${0}")")/config.rc" ] && . $(dirname "$(readlink -f "${0}")")/config.rc
		echo -n "${additional_interfaces}"

		exit 0
	;;
	'getInterfacesInfo')
		[ "$2" = '' ] && exit 0
		interfaces=$(echo "${@}" | sed 's/getInterfacesInfo //g') # arg filter
		[ -e "$(dirname "$(readlink -f "${0}")")/config.rc" ] && . $(dirname "$(readlink -f "${0}")")/config.rc # Read the rest of the config

		# Parse config file
		for i in ${interfaces}; do
			# Read interface speed
			interface_speed=$(cat /sys/class/net/${i}/speed 2>/dev/null) # Ethernet speed
			[ -e "/sys/class/net/${i}/wireless/link" ] && interface_speed=$(cat /sys/class/net/${i}/wireless/link 2>/dev/null) # WiFi speed
			[ "$(eval echo -n \${speed_${i}})" = '' ] || interface_speed="$(eval echo -n \${speed_${i}})" # Custom interface speed

			# Check if speed is defined
			if [ "${interface_speed}" = '' ]; then # Unknown speed/Not connected
				echo "${i}|null|$(eval echo -n \${label_${i}})"
			else # Standard output
				echo "${i}|${interface_speed}|$(eval echo -n \${label_${i}})" # Mb/s
			fi
		done

		exit 0
	;;
esac

exit 0
