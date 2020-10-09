<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php chdir($system['location_php']); ?>
<?php
	$shell_sh_location=$system['location_php'] . '/sys-users/shell.sh';

	if((isset($_POST['kick_user'])) && (csrf_checkToken('post')))
		if(strpos($_POST['kick_user'], '\'') === false) shell_exec($shell_sh_location . ' kick_user ' . '\''.$_POST['kick_user'].'\'');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Logged users</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<style type="text/css">
			table { border: 1px solid var(--content_border-color); }
			th, td { white-space: nowrap; }
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
						<?php echo shell_exec($shell_sh_location . ' logged_users'); ?>
					</table>
					<?php echo csrf_injectToken(); ?>
				</form>
			</div>
		</div>
	</body>
</html>