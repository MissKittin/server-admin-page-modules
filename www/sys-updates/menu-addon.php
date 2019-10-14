<?php
	if($plugin === $plugin_last)
	{ ?>
		&#9492;&#9472;<a href="<?php echo $system_location_html; ?>/sys-updates" onclick="alert('Long loading, please be patient.');">Updates</a><br>
	<?php }
	else
	{ ?>
		&#9500;&#9472;<a href="<?php echo $system_location_html; ?>/sys-updates" onclick="alert('Long loading, please be patient.');">Updates</a><br>
	<?php }
?>

