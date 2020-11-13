#!/bin/sh
# Check availability of shell commands

# go to $system['location_php']
cd $(dirname $0)/../..

# function that searches in $PATH
check_command()
{
	# $1 -> command name
	for x in $(echo ${PATH} | tr ':' ' ' ); do
		[ -e "${x}/${1}" ] && return 0
	done
	return 1
}

# main function
f_main()
{
	echo "${1}:"
	find -L -type f -name "*.sh" -o -name "*.rc" 2>/dev/null | while read line; do
		[ "$line" = "$0" ] || cat ${line} | grep '^# '"$2"':'| sed -e 's/# '"$2"': //g' | tr -d ',' | while read lineB; do
			echo ${lineB} | xargs
		done
	done | xargs | tr ' ' '\n' | sort -u | for i in $(cat); do
		if check_command ${i}; then
			echo "[OK] ${i}"
		else
			echo "[Fail] ${i}"
		fi
	done
}

# main - required
f_main 'Required commands' 'Command stack'

# main - optional
echo ''
f_main 'Optional commands' 'Optional command stack'

exit 0
