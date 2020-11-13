<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('check-dash.php'); ?>
<?php
	if(!file_exists('/bin/sh'))
	{
		echo '<div><span class="content_warning">&#9760; Stop: no /bin/sh</span>';
		echo '<script>document.getElementsByName("user")[0].disabled=true; document.getElementsByName("password")[0].disabled=true; document.getElementsByTagName("INPUT")[2].style.display="none";</script></div>';
	}
?>
<?php echo shell_exec($system['location_php'] . '/login-plugins/' . $plugin . '/shell.sh check-dash'); ?>
