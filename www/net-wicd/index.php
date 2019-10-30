<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php chdir($system['location_php']); ?>
<?php
	// wicd php gui - server-admin-page module
	// 22.10.2019 - 26.10.2019

	// config
	$wicd_range_icons=$system['location_html'] . '/lib/range_icons'; // path to range icons
	$wicd_theme='bright';

	// path settings
	$wicd_root_php=$system['location_php'] . strtok($_SERVER['REQUEST_URI'], '?');
	$wicd_root_html=$system['location_html'] . strtok($_SERVER['REQUEST_URI'], '?');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Wicd</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $wicd_root_html; ?>/style.php?root=<?php echo $wicd_root_html; ?>&theme=<?php echo $wicd_theme; ?>">
		<?php include('./lib/opt_htmlheaders/jquery.php'); ?>
		<script src="<?php echo $wicd_root_html; ?>/script.php?root=<?php echo $wicd_root_html; ?>&icons=<?php echo $wicd_range_icons; ?>"></script>
		<style type="text/css">
			#wicd_margin {
				width: 420px;
				height: 1px;
			}
		</style>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<?php include($wicd_root_php . '/body.php'); ?>
				<div id="wicd_margin"></div>
			</div>
		</div>
	</body>
</html>