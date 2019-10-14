<?php include($system_location_php . '/lib/prevent-direct.php'); prevent_direct('sample-widget-php'); ?>
<?php
	if(!file_exists('/bin/sh'))
	{
		echo '<div><span style="color: #ff0000;">&#9760; Stop: no /bin/sh</span>';
		echo '<script>document.getElementsByName("user")[0].disabled=true; document.getElementsByName("password")[0].disabled=true; document.getElementsByTagName("INPUT")[2].style.display="none";</script></div>';
	}
?>
<?php echo shell_exec($system_location_php . '/login-plugins/' . $plugin . '/shell.sh check-dash'); ?>
