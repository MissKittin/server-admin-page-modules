#!/bin/sh

echo '05_notifications'
cd home-plugins/05_notifications
rm index.php
ln -s ../../lib/prevent-index.php index.php
chmod 755 shell.sh

echo 'range_icons'
cd ../../lib/range_icons
rm index.php
ln -s ../prevent-index.php index.php

echo 'shell libs'
cd ../shell
rm index.php
ln -s ../prevent-index.php index.php

echo '01_internet-info'
cd ../../login-plugins/01_internet-info
rm index.php
ln -s ../../lib/prevent-index.php index.php
chmod 755 shell.sh

echo '05_check-dash'
cd ../05_check-dash
rm index.php
ln -s ../../lib/prevent-index.php index.php
chmod 755 shell.sh

echo 'net-wifi'
cd ../../net-wifi
chmod 755 shell.sh

echo 'power'
cd ../power
chmod 755 shell.sh

echo 'storage'
cd ../storage
chmod 755 shell.sh

echo 'sys-notifications'
cd ../sys-notifications
chmod 755 shell.sh

echo 'sys-sensors'
cd ../sys-sensors
chmod 755 shell.sh

echo 'sys-updates'
cd ../sys-updates
chmod 755 shell.sh

echo 'sys-users'
cd ../sys-users
chmod 755 shell.sh

echo 'setup.sh'
cd ..
rm setup.sh

echo; echo 'OK'
exit 0
