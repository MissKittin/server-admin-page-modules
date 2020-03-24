#!/bin/sh
# Superuser library
# required /etc/sudoers: ALL=NOPASSWD: LABEL
# 17.01.2020

# Disable superuser
# exec $@

# Path to sudo
SUDO__PATH='/usr/bin/sudo'

# Path to whoami
WHOAMI__PATH='/usr/bin/whoami'

if [ ! "$($WHOAMI__PATH)" = "root" ]; then
	# Elevate this script
	exec $SUDO__PATH $0 $@
else
	# Now is elevated, exec script
	exec $@
fi
