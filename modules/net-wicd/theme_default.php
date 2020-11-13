<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php
	// wicd php gui - default theme
	// 22.10.2019 - 26.10.2019

	// filetype header
	header("Content-Type: text/css; X-Content-Type-Options: nosniff;");
?>

/* fonts */
	body {
		font-size: 16px;
	}

/* buttons */
	.button {
		border: 1px solid #666666;
		border-radius: 15px;
	}

/* global for all windows */
	.wicd_window {
		background-color: #999999;
		color: #000000;
	}
	.wicd_titleBar {
		background-color: #000099;
	}

/* wicd main window */
	#wicd_content {
		background-color: #bbbbbb;
	}
	#wicd_contentNetworksActiontext {
		color: #555555;
		font-weight: bold;
	}
	.wicd_contentNetworksNetwork {
		border: 1px solid #999999;
	}
	.wicd_contentNetworksNetworkName {
		font-weight: bold;
		color: #000000;
	}
	.wicd_contentNetworksNetworkDetails {
		color: #000000;
	}
	#wicd_status {
		color: #000000;
	}