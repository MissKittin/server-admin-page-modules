<?php include($system['location_php'] . '/lib/login/login.php'); ?>
<?php chdir($system['location_php']); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Bandwidth usage</title>
		<?php include($system['location_php'] . '/lib/htmlheaders.php'); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $system['location_html']; ?>/net-bwusage/style">
		<script src="<?php echo $system['location_html']; ?>/net-bwusage/script"></script>
	</head>
	<body>
		<?php include($system['location_php'] . '/lib/header.php'); ?>
		<div id="system_body">
			<?php include($system['location_php'] . '/lib/menu/menu.php'); ?>
			<div id="system_content">
				<h1>Bandwidth usage</h1>
				<div><table id="outputTable"><tr><td><h3 style="padding-left: 20px;">Loading...</h3></td></tr></table></div>
				<h1>Explanation</h1>
				<div id="explantation">
					<table>
						<tr><td rowspan="2" style="text-align: right;">[LAN host]</td><td style="text-align: center;">&#8592; transmitted &#9472;&#9472;&#9472;&#9472;</td><td rowspan="2" style="text-align: left;">[router]</td></tr>
						<tr>		<td style="text-align: center;">&#9472;&#9472;&#9472;&#9472;&#9472; received &#8594;</td>						</tr>
						<tr><td colspan="3"><hr></td></tr>
						<tr><td rowspan="2" style="text-align: right;">[router]</td><td style="text-align: center;">&#8592; received &#9472;&#9472;&#9472;&#9472;&#9472;&#9472;</td><td rowspan="2" style="text-align: left;">[gateway]</td></tr>
						<tr>		<td style="text-align: center;">&#9472;&#9472;&#9472;&#9472;&#9472; transmitted &#8594;</td>					</tr>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>