<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php chdir($system['location_php']); ?>
<?php
	if(isset($_POST['kick_user']))
	{
		shell_exec('/usr/bin/pkill -9 -t ' . $_POST['kick_user']);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Logged users</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<style type="text/css">
			table {
				border: 1px solid var(--content_border-color);
			}
			th, td {
				white-space: nowrap;
			}
		</style>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>Logged users</h1>
				<form action="sys-users" method="post">
					<table>
						<tr><th>User</th><th>Term</th><th>Date</th><th>IP</th></tr>
						<?php echo shell_exec($system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?') . '/shell.sh logged_users'); ?>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>