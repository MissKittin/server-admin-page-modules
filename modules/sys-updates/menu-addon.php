<?php
	if($plugin === $plugin_last)
	{ ?>
		&#9492;&#9472;<a href="<?php echo $system['location_html']; ?>/sys-updates?<?php echo csrf_printToken('parameter'); ?>=<?php echo csrf_printToken('value'); ?>" onclick="if(!confirm('Long loading, please be patient.')) return false;">Updates</a><br>
	<?php }
	else
	{ ?>
		&#9500;&#9472;<a href="<?php echo $system['location_html']; ?>/sys-updates?<?php echo csrf_printToken('parameter'); ?>=<?php echo csrf_printToken('value'); ?>" onclick="if(!confirm('Long loading, please be patient.')) return false;">Updates</a><br>
	<?php }
?>

