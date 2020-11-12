#!/bin/sh

echo 'range_icons'
cd lib/range_icons
[ -e index.php ] && rm index.php
ln -s ../prevent-index.php index.php

echo 'login-themes/material'
cd ../login/login-themes/material
[ -e index.php ] && rm index.php
ln -s ../../../prevent-index.php index.php
cd css
ln -s index.min.php index.php

echo 'console'
cd ../../../../console
chmod 755 check-command-stack.sh
ln -s ../prevent-index.php index.php

echo 'favicon'
cd ../favicon
[ -e index.php ] && rm index.php
ln -s ../prevent-index.php index.php

echo 'opt_htmlheaders'
cd ../opt_htmlheaders
[ -e index.php ] && rm index.php
ln -s ../prevent-index.php index.php

echo 'shell libs'
cd ../shell
[ -e index.php ] && rm index.php
ln -s ../prevent-index.php index.php

echo 'superuser'
chmod 750 ./superuser.sh

echo 'themes'
cd ../themes
ln -s ../prevent-index.php index.php

echo 'themes/bright'
cd bright
ln -s index.min.php index.php

echo 'themes/dark'
cd ../dark
ln -s index.min.php index.php

echo '01_internet-info'
cd ../../../login-plugins/01_internet-info
[ -e index.php ] && rm index.php
ln -s ../../lib/prevent-index.php index.php
chmod 755 shell.sh

echo '05_check-dash'
cd ../05_check-dash
[ -e index.php ] && rm index.php
ln -s ../../lib/prevent-index.php index.php
chmod 755 shell.sh

echo '15_check-js'
cd ../15_check-js
[ -e index.php ] && rm index.php
ln -s ../../lib/prevent-index.php index.php

echo 'net-wifi'
cd ../../net-wifi
chmod 755 shell.sh

echo 'net-ap'
cd ../net-ap
chmod 755 shell.sh

echo 'net-bwusage'
cd ../net-bwusage
chmod 755 shell.sh
cd script
ln -s index.min.php index.php
cd ../style
ln -s index.min.php index.php

echo 'net-devices'
cd ../../net-devices
chmod 755 shell.sh

echo 'net-wired'
cd ../net-wired
chmod 755 shell.sh

echo 'sys-daemons'
cd ../sys-daemons
chmod 755 shell.sh

echo 'sys-logs'
cd ../sys-logs
chmod 755 shell.sh

echo 'net-wicd'
cd ../net-wicd
chmod 755 shell.sh
chmod 755 wicd-config-injection.sh

echo 'sys-clock'
cd ../sys-clock
chmod 755 shell.sh

echo 'sys-storage'
cd ../sys-storage
chmod 755 shell.sh
cd script
ln -s index.min.php index.php
cd ../style
ln -s index.min.php index.php

echo 'sys-sensors'
cd ../../sys-sensors
chmod 755 shell.sh

echo 'sys-updates'
cd ../sys-updates
chmod 755 shell.sh

echo 'sys-users'
cd ../sys-users
chmod 755 shell.sh

cd ..
while true; do
	error=false
	echo; echo -n 'download jquery? [y/n] '
	read answer
	if [ "$answer" = 'y' ]; then
		cd lib
		echo 'jquery-3.3.1.min.js'
		wget https://code.jquery.com/jquery-3.3.1.min.js > /dev/null 2>&1 && ln -s jquery-3.3.1.min.js jquery.js || error=true
		echo 'jquery-1.9.1.min.js'
		wget http://code.jquery.com/jquery-1.9.1.min.js > /dev/null 2>&1 && ln -s jquery-1.9.1.min.js jquery-old.js || error=true
		if $error; then
			while true; do
				echo; echo -n 'download failed, create download script? [y/n] '
				read answerb
				if [ "$answerb" = 'y' ]; then
					cd ..
					echo '#!/bin/sh' > download-jquery.sh
					echo 'error=false' >> download-jquery.sh
					echo 'cd lib' >> download-jquery.sh
					echo 'echo "jquery-3.3.1.min.js"' >> download-jquery.sh
					echo 'wget https://code.jquery.com/jquery-3.3.1.min.js > /dev/null 2>&1 && ln -s jquery-3.3.1.min.js jquery.js || error=true' >> download-jquery.sh
					echo 'echo "jquery-1.9.1.min.js"' >> download-jquery.sh
					echo 'wget http://code.jquery.com/jquery-1.9.1.min.js > /dev/null 2>&1 && ln -s jquery-1.9.1.min.js jquery-old.js || error=true' >> download-jquery.sh
					echo 'cd ..' >> download-jquery.sh
					echo '$error && echo "download error!"' >> download-jquery.sh
					echo '$error || rm download-jquery.sh' >> download-jquery.sh
					echo 'exit 0' >> download-jquery.sh
					chmod 755 download-jquery.sh
					cd lib
					break
				fi
				[ "$answerb" = 'n' ] && break
			done
		fi
		cd ..
		break
	fi
	[ "$answer" = 'n' ] && break
done

while true; do
	echo; echo -n 'remove deprecated net-wifi module? [y/n] '
	read answer
	if [ "$answer" = 'y' ]; then
		echo 'rm net-wifi'
		rm -r net-wifi
		break
	fi
	[ "$answer" = 'n' ] && break
done

while true; do
	echo; echo -n 'remove deprecated net-ap module? [y/n] '
	read answer
	if [ "$answer" = 'y' ]; then
		echo 'rm net-ap'
		rm -r net-ap
		break
	fi
	[ "$answer" = 'n' ] && break
done

while true; do
	echo; echo -n 'remove deprecated sys-updates module? [y/n] '
	read answer
	if [ "$answer" = 'y' ]; then
		echo 'rm sys-updates'
		rm -r sys-updates
		break
	fi
	[ "$answer" = 'n' ] && break
done

while true; do
	echo; echo -n 'remove module-compatibility header? [y/n] '
	read answer
	if [ "$answer" = 'y' ]; then
		echo 'rm module-compatibility.php'
		cd lib
		rm -r htmlheaders
		cd ..
		break
	fi
	[ "$answer" = 'n' ] && break
done

echo; echo 'setup.sh'
rm setup.sh

echo; echo 'OK'
exit 0
