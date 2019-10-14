<?php include($system_location_php . '/lib/prevent-direct.php'); prevent_direct('notifications.php');?>
<?php
	if(isset($_GET['remove-notify']))
	{
		shell_exec($system_location_php . '/home-plugins/' . $plugin . '/shell.sh remove-notify ' . $_GET['remove-notify']);
		goto_home();
	}
?>
<div id="notifications">
	<?php
		$notifications=shell_exec($system_location_php . '/home-plugins/' . $plugin . '/shell.sh get-notifications');
		if($notifications != '')
		{
			echo '<h1>Notifications</h1>';
			echo "$notifications";
		}
		unset($notifications); // clear environment
	?>
</div>
