<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('form.php'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $system['title']; ?> Login</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $system['location_html']; ?>/lib/login/login-themes/<?php echo $system['login_theme']; ?>/css">
	</head>
	<body>
		<div id="login_body">
			<form action="." method="post">
				<div id="login_box">
					<div class="input_field">
						<label for="user">Login</label>
						<input type="text" name="user">
					</div>
					<div class="input_field">
						<label for="password">Password</label>
						<input type="password" name="password">
					</div>
					<div id="input_buttons">
						<input type="submit" value="Login" class="button">
					</div>
				</div>
				<?php echo csrf_injectToken(); ?>
			</form>
			<br>
			<div id="system_login_content">
				<?php
					// Widgets render part
					$plugins=scandir($system['location_php'] . '/login-plugins');

					foreach($plugins as $plugin)
						if(($plugin != '.') && ($plugin != '..') && (is_dir($system['location_php'] . '/login-plugins/' . $plugin))) // directory filter
							if(!file_exists($system['location_php'] . '/login-plugins/' . $plugin . '/disabled')) // check if widget is not disabled
								include($system['location_php'] . '/login-plugins/' . $plugin . '/' . str_replace('_', '', strstr($plugin, '_')) . '.php');
					unset($plugins); unset($plugin) // clear environment
				?>
			</div>
		</div>
	</body>
</html>