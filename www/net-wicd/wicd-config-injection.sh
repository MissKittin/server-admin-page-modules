#!/bin/bash
# wicd config variable injection
# 25.10.2019
# Command stack: mktemp cat read grep rm

# Automatic settings
WICD_SAVED_APS="$1"
WICD_SAVED_APS_OUTPUT="$2"
WICD_STATUS_COMMAND="$3"

# Functions
wicd_checkConfigValue()
{
	#$1->ap_mac $2->variable
	#returns 'true', 'false', 'undefined' or string by echo

	local print=false
	local line=''
	local wicd_checkConfigValueOutput=''
	local wicd_checkConfigValueOutputFile=$(mktemp --suffix=wicd_checkConfigValueOutput)

	cat ${WICD_SAVED_APS} | while read line; do
		if [ "${line:0:1}" = "[" ]; then
			[ "$line" = "[$1]" ] && print=true || print=false
		fi
		if $print; then
			if echo "$line" | grep "$2" > /dev/null 2>&1; then
				echo "wicd_checkConfigValueOutput=${line##*${2} = }" > ${wicd_checkConfigValueOutputFile}
			fi
		fi
	done

	if [ -e ${wicd_checkConfigValueOutputFile} ]; then
		eval $(cat ${wicd_checkConfigValueOutputFile})
		rm ${wicd_checkConfigValueOutputFile}
	fi

	if [ "${wicd_checkConfigValueOutput}" = '1' ]; then
		echo "true"
	elif [ "${wicd_checkConfigValueOutput}" = '0' ]; then
		echo "false"
	elif [ "${wicd_checkConfigValueOutput}" = '' ]; then
		echo "undefined"
	else
		echo "${wicd_checkConfigValueOutput}"
	fi

}

wicd_renameConfigValue()
{
	#$1->ap_mac $2->variable $3->value

	local rename=false
	local line=''
	local tempOutput=$(mktemp --suffix=wicd_renameConfigValueOutput)
	cat ${WICD_SAVED_APS} | while read line; do
		if [ "${line:0:1}" = "[" ]; then
			[ "$line" = "[$1]" ] && rename=true || rename=false
		fi
		if $rename; then
			if echo "$line" | grep "$2" > /dev/null 2>&1; then
				echo "${2} = ${3}" >> ${tempOutput}
			else
				echo "$line" >> ${tempOutput}
			fi
		else
			echo "$line" >> ${tempOutput}
		fi
	done

	cat ${tempOutput} > ${WICD_SAVED_APS_OUTPUT}
	rm ${tempOutput}
}

wicd_addConfigValue()
{
	#$1->ap_mac $2->variable $3->value
	#adding entry before [mac] start

	local add=false
	local line=''
	local tempOutput=$(mktemp --suffix=wicd_addConfigValueOutput)
	cat ${WICD_SAVED_APS} | while read line; do
		if $add; then
			echo "${2} = ${3}" >> ${tempOutput}
			echo "$line" >> ${tempOutput}
			add=false
		else
			echo "$line" >> ${tempOutput}
		fi
		if [ "${line:0:1}" = "[" ]; then
			[ "$line" = "[$1]" ] && add=true || add=false
		fi
	done

	cat ${tempOutput} > ${WICD_SAVED_APS_OUTPUT}
	rm ${tempOutput}
}

# Main
case $4 in
	#$5->ap_mac $6->variable $7->value
	'checkAutomaticValue')
		[ "$(wicd_checkConfigValue "$5" "$6")" = "$7" ] && echo -n 'true' || echo -n 'false'
	;;
	'renameAutomaticValue')
		if [ "$(wicd_checkConfigValue "$5" "$6")" = "$7" ]; then
			echo 'isOK'
		elif [ "$(wicd_checkConfigValue "$5" "$6")" = 'undefined' ]; then
			case $7 in
				'true')
					newValue='1'
				;;
				'false')
					newValue='0'
				;;
				*)
					exit 0
				;;
			esac
			wicd_addConfigValue "$5" "$6" "$newValue"

			${WICD_STATUS_COMMAND} restart > /dev/null 2>&1
			echo -n 'added'
		else
			case $7 in
				'true')
					newValue='1'
				;;
				'false')
					newValue='0'
				;;
				*)
					exit 0
				;;
			esac
			wicd_renameConfigValue "$5" "$6" "$newValue"

			${WICD_STATUS_COMMAND} restart > /dev/null 2>&1
			echo -n 'changed'
		fi
	;;
esac

exit 0
