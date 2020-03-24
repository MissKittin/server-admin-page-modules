<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('notifications.php');?>
<?php
	if(isset($_GET['remove-notify']))
	{
		shell_exec($system['location_php'] . '/home-plugins/' . $plugin . '/shell.sh remove-notify ' . $_GET['remove-notify']);
		echo '<meta http-equiv="refresh" content="0; url=' . $system['location_html'] . '/">';
	}
?>
<div id="notifications">
	<?php
		$notifications=shell_exec($system['location_php'] . '/home-plugins/' . $plugin . '/shell.sh get-notifications');
		if($notifications != '')
		{
			echo '<h1>Notifications</h1>';
			echo "$notifications";
		}
		unset($notifications); // clear environment
	?>
</div>
