<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('index.full.php'); ?>
<?php header('Content-Type: text/css; X-Content-Type-Options: nosniff;'); ?>
.bar-out {
	background-color: #000000;
	height: 5px;
	width: 100px;
	border: 1px solid var(--content_border-color);
	margin: 0;
	padding: 0;
}
.bar-in {
	background-color: #ffffff;
	left: 0;
	height: 5px;
	/* add width: Npx; to local styles */
	margin: 0;
	padding: 0;
}