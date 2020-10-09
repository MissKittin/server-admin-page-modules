<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('index.full.php'); ?>
<?php header('Content-Type: text/css; X-Content-Type-Options: nosniff;'); ?>
#system_content table {
	border: 1px solid var(--content_border-color);
}
#system_content .bar-out {
	height: 5px;
	width: 100px;
	border: 1px solid var(--content_border-color);
	margin: 0;
	padding: 0;
}
#system_content .bar-in {
	left: 0;
	height: 5px;
	/* add width: Npx; to local styles */
	margin: 0;
	padding: 0;
}