# server-admin-page-modules
several modules that are less dependent on my configuration  
compatible with server-admin-page v3.1  
system core: https://github.com/MissKittin/server-admin-page  

net-wifi -> control wicd (dependent of jquery, deprecated)  
net-wicd -> wicd php gui v2, standalone version: https://github.com/MissKittin/wicd-php-gui  
power -> halt, reboot or suspend server (removed)  
sys-storage -> list free/used space on disks and ramdisks  
sys-clock -> display clock and sync by ntpdate-debian  
sys-notifications -> control notify-daemon (removed)  
sys-sensors -> list `sensors`  
sys-updates -> update apt database (dependent of apt-check, deprecated)  
sys-users -> list logged users and kick selected  

home plugins:  
notifications -> get notifications from notify-daemon (removed)  
login plugins:  
internet-info -> list public IPv4  
check-dash -> check if dash is installed (for shellscripts)   

additional files:  
apt-check -> for sys-updates  
www.rc -> for notifications home plugin (put it in /usr/local/etc/notify-daemon/journal-manager.rc.d) (removed)  

# how to update
after setup `chown -R root:root *` (of course as root) and `tar cvf ../update.tar *`.  
transfer update.tar to document root (in debian router /usr/local/share/www) and `tar xvf update.tar; rm update.tar` (as root)  
done!

# updates
mobileview: v1.1 with animations, if you want v1, change `var useAnimations=true;` to `var useAnimations=false;`  
fadeanimations: now doesn't blocking application in older browsers  
csrf prevention implemented in all modules  
superuser.sh needs webadmin.pid - configuration is in this file

# screenshots
storage  
![storage](storage.png?raw=true)  

sys-notifications  
![notifications](sys-notifications.png?raw=true)  

wicd php gui  
![wicd](net-wicd.png?raw=true)  

mobileview  
![mobileview1](preview_mobileview1.png?raw=true)  
![mobileview2](preview_mobileview2.png?raw=true)
