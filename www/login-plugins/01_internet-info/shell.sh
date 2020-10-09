#!/bin/dash
# Command stack: dash, dirname

# Import config file
. $(dirname "$0")/config.rc > /dev/null 2>&1 || exit 0

# Import PATH variable
if [ -e ./lib/shell/path.rc ]; then
	. ./lib/shell/path.rc
else
	. ../lib/shell/path.rc
fi

# Import check ipv4 library
if [ -e ./lib/shell/public-ipv4.rc ]; then
	. ./lib/shell/public-ipv4.rc
else
	. ../lib/shell/public-ipv4.rc
fi

# Import check ipv6 library
if [ -e ./lib/shell/check-ipv6.rc ]; then
	. ./lib/shell/check-ipv6.rc
else
	. ../lib/shell/check-ipv6.rc
fi

exit 0
