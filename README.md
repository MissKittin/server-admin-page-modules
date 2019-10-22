# server-admin-page-modules
several modules that are less dependent on my configuration<br><br>
net-wifi -> control wicd (dependent of jquery)<br>
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
setup links - run setup.sh<br><br>

jquery:<br>
1) download https://code.jquery.com/jquery-3.3.1.min.js, put it in lib and `ln -s jquery-3.3.1.min.js jquery.js`<br>
2) download http://code.jquery.com/jquery-1.9.1.min.js, put it in lib and `ln -s jquery-1.9.1.min.js jquery-old.js`<br><br>

# screenshots
storage<br>
![alt text](https://github.com/MissKittin/server-admin-page-modules/blob/master/storage.png)<br><br>
sys-notifications<br>
![alt text](https://github.com/MissKittin/server-admin-page-modules/blob/master/sys-notifications.png)
