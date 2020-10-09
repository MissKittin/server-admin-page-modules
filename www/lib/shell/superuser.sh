#!/bin/sh
# Superuser library
# 17.01.2020
# PID control 27.05.2020
# Command stack: sudo whoami cat awk

# required in /etc/sudoers: ALL=NOPASSWD: WEBADMIN_SUPERUSER_CMD_LABEL
# Shebang: #![path_to_server-admin-page]/lib/shell/superuser.sh [path-to-interpreter]
# for console/update-shebang.php in second line: #?php has_superuser_shebang
# Input args: [path_to_interpreter] [path_to_script]

# Disable superuser below
# exec $@

# Settings
WEBADMIN__PID='/tmp/.rclocal_daemons_logs/.webadmin.pid' # Path to webadmin.pid (generated from /usr/local/sbin/webadmin.sh)
SUDO__PATH='/usr/bin/sudo' # Path to sudo
WHOAMI__PATH='/usr/bin/whoami' # Path to whoami

# Check if I am root
if [ ! "$(${WHOAMI__PATH})" = 'root' ]; then
	# Check if second-level parent PID is a php server PID
	[ "$(cat /proc/$(cat /proc/$$/stat | awk '{print $4}')/stat | awk '{print $4}')" = "$(cat $WEBADMIN__PID)" ] || exit 0
	# Parent's PID is ok, elevate this script
	exec $SUDO__PATH $0 $@
else
	# Now script is elevated, only exec script
	exec $@
fi
