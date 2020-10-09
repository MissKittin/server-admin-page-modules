<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('reload.php'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $system['title']; ?></title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $system['location_html']; ?>/lib/login/login-themes/<?php echo $system['login_theme']; ?>/css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="refresh" content="0">
	</head>
	<body>
		<h1 id="loading">Loading...</h1>
	</body>
</html>