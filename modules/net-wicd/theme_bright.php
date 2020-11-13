<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php
	// wicd php gui - bright theme
	// 28.10.2019

	// filetype header
	header("Content-Type: text/css; X-Content-Type-Options: nosniff;");
?>

/* fonts */
	body {
		font-size: 16px;
	}

/* buttons */
	.button {
		border: 1px solid var(--content_border-color);
		border-radius: 15px;
		background-color: #fffee0;
	}

/* global for all windows */
	.wicd_window {
		background-color: #eeedd0;
		border: 1px solid var(--content_border-color);
		border-radius: 5px;
		color: #000000;
	}
	.wicd_titleBar {
		background-color: #000099;
		border-radius: 5px;
	}

/* wicd main window */
	#wicd_content {
		background-color: #eeedd0;
		border: 1px solid var(--content_border-color);
		border-radius: 5px;
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