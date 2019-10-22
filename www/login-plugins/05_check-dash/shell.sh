#!/bin/sh

# Import PATH variable
if [ -e ./lib/shell/path.rc ]; then
	. ./lib/shell/path.rc
else
	. ../lib/shell/path.rc
fi

case $1 in
	'check-dash')
		if [ ! -e /bin/dash ]; then
			echo '<div><span style="color: #ff0000;">&#9760; This application will not work until you install dash</span>'
			echo '<script>document.getElementsByName("user")[0].disabled=true; document.getElementsByName("password")[0].disabled=true; document.getElementsByTagName("INPUT")[2].style.display="none";</script></div>' 
		fi
	;;
esac

exit 0
