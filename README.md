# server-admin-page-modules
several modules that are less dependent on my configuration<br>
compatible with server-admin-page v3.1<br>
system core: https://github.com/MissKittin/server-admin-page<br>
whole project: https://github.com/MissKittin/debian-router<br><br>

net-wifi -> control wicd (dependent of jquery, deprecated)<br>
net-wicd -> wicd php gui v2, standalone version: https://github.com/MissKittin/wicd-php-gui<br>
power -> halt, reboot or suspend server<br>
storage -> list free/used space on disks and ramdisks<br>
sys-clock -> display clock and sync by ntpdate-debian<br>
sys-notifications -> control notify-daemon<br>
sys-sensors -> list `sensors`<br>
sys-updates -> update apt database (dependent of apt-check)<br>
sys-users -> list logged users and kick selected<br><br>

home plugins:<br>
notifications -> get notifications from notify-daemon<br><br>
login plugins:<br>
internet-info -> list public IPv4<br>
check-dash -> check if dash is installed (for shellscripts)<br><br>

headers:<br>
fadeanimations -> fade in/out animations on body load/unload<br>
module-compatibility -> run older modules on server-admin-page v3.1<br>
mobileview -> adjust layout for mobile devices<br><br>

themes:<br>
bright -> default theme with better colors<br>
dark<br><br>

additional files:<br>
apt-check -> for sys-updates<br>
www.rc -> for notifications home plugin (put it in /usr/local/etc/notify-daemon/journal-manager.rc.d)<br><br>

**run setup.sh after clone**<br><br>

# how to update
after setup `chown -R root:root *` (of course as root) and `tar cvf ../update.tar *`.<br>
transfer update.tar to document root (in debian router /usr/local/share/www) and `tar xvf update.tar; rm update.tar` (as root)<br>
done!
<br><br>

# updates
mobileview: v1.1 with animations, if you want v1, change `var useAnimations=true;` to `var useAnimations=false;`<br>
fadeanimations: now doesn't blocking application in older browsers<br>
csrf prevention implemented in all modules<br><br>

# for developers
if fadeanimations are enabled, window.onload and window.onbeforeunload is reserved only for this.<br><br>

# screenshots
storage<br>
![storage](https://github.com/MissKittin/server-admin-page-modules/blob/master/storage.png)<br><br>
sys-notifications<br>
![notifications](https://github.com/MissKittin/server-admin-page-modules/blob/master/sys-notifications.png)<br><br>
wicd php gui<br>
![wicd](https://raw.githubusercontent.com/MissKittin/server-admin-page-modules/master/net-wicd.png)<br><br>
mobileview<br>
![mobileview1](https://raw.githubusercontent.com/MissKittin/server-admin-page-modules/master/preview_mobileview1.png)
![mobileview2](https://raw.githubusercontent.com/MissKittin/server-admin-page-modules/master/preview_mobileview2.png)
