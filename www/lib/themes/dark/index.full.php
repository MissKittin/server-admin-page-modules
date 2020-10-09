<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('index.full.php'); ?>
<?php header('Content-Type: text/css; X-Content-Type-Options: nosniff;'); ?>
<?php header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT'); header('Pragma: cache'); header('Cache-Control: max-age=3600'); ?>
/* dark theme */
/* 28.10.2019 */

/* variables */
:root {
	--content_border-color: #aaaaaa; /* border color */
	--content_text-color: #ffffff; /* default text color */
	--content_background-color: #000000; /* default background color */
}

/* menu */
#system_body #system_menu a, #system_body #system_menu a:hover, #system_body #system_menu a:visited {
	text-decoration: none;
	color: #cccccc;
}
#system_body #system_menu {
	color: #ff0000;
}

/* page */
body {
	color: var(--content_text-color);
	color: #ffffff; /* for older browsers */
	background-color: var(--content_background-color);
	background-color: #000000; /* for older browsers */
}
#system_body #system_content {
	margin-left: 201px; /* comment this if you use default menu module */
}
#system_body #system_content a, #system_body #system_content a:hover, #system_body #system_content a:visited {
	color: #cccccc;
}

/* links without decorations */
#system_body #system_content .content_noDecorations, #system_login_content .content_noDecorations {
	text-decoration: none;
	color: #0ff0ff !important;
}

/* warning messages */
#system_body #system_content .content_warning, #system_login_content .content_warning {
	color: #ff0000;
}