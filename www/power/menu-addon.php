<?php
	if($plugin === $plugin_last)
	{ ?>
		&#9500;&#9472;Action<br>
			&#9500;&#9472;&#9472;<a href="<?php echo $system_location_html; ?>/power?do=halt" onclick="return confirm('Are you sure?');">Halt</a><br>
			&#9500;&#9472;&#9472;<a href="<?php echo $system_location_html; ?>/power?do=reboot" onclick="return confirm('Are you sure?');">Reboot</a><br>
			&#9492;&#9472;&#9472;<a href="<?php echo $system_location_html; ?>/power?do=suspend" onclick="return confirm('Are you sure?');">Suspend</a><br>
	<?php }
	else
	{ ?>
		&#9500;&#9472;Action<br>
			&#9500;&#9472;&#9472;<a href="<?php echo $system_location_html; ?>/power?do=halt" onclick="return confirm('Are you sure?');">Halt</a><br>
			&#9500;&#9472;&#9472;<a href="<?php echo $system_location_html; ?>/power?do=reboot" onclick="return confirm('Are you sure?');">Reboot</a><br>
			&#9500;&#9472;&#9472;<a href="<?php echo $system_location_html; ?>/power?do=suspend" onclick="return confirm('Are you sure?');">Suspend</a><br>
	<?php }
?>

