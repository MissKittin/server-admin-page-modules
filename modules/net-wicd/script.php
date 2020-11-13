<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php if(!isset($_GET['icons'])) { include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('script.php'); exit(); } ?>
<?php if(!isset($_GET['root'])) { include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('script.php'); exit(); } ?>
<?php
	// wicd php gui - jquery backend
	// 22.10.2019 - 26.10.2019
	// csrf protection 19.03.2020

	// filetype header
	header("Content-type: text/javascript; charset: UTF-8");
	header("Cache-Control: must-revalidate");

	// generate unique token and store it on server side
	$_SESSION['wicd_csrfToken']=substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
?>

// settings
var wicd_debugFlag=false; // enable/disable console.log()

// flags
var wicd_startFlag=true; // if an error occured
/* var wicd_addNetworkName is defined on body and removed on add network window close */

// auto-generated flags
var wicd_csrfToken='&wicd_csrfToken=<?php echo $_SESSION['wicd_csrfToken']; ?>'; // send token on client side

/* starter */
$(document).ready(function(){
	if(wicd_startFlag)
	{
		if(wicd_debugFlag) console.log('start: starting application...');

		wicd_defineEvents();
		wicd_getConnectionStatus();
		wicd_getNetworkList();

		if(wicd_debugFlag) console.log('start: application ready');
	}
	else
	{
		wicd_defineEvents();
		if(wicd_debugFlag) console.log('system error, stop');
	}
});

/* define events */
function wicd_defineEvents()
{
	if(wicd_debugFlag) console.log('defineEvents: started');

	/* windows - settings */

		/* close settings */
		$("#wicd_closeSettings").click(function(){
			document.getElementById('wicd_settings').style.display='none';
			if(wicd_debugFlag) console.log('event: settings closed');
		});

		/* apply settings */
		$("#wicd_settingsApply").click(function(){
			var wirelessInterface=$('#wicd_settingsWirelessInterface').val();
			$.get('<?php echo $_GET['root']; ?>/shell.php?wicd=setWifiDevice&device=' + wirelessInterface + wicd_csrfToken, function(data){
				if(wicd_debugFlag) console.log('event: settingsApply: set wireless interface to ' + wirelessInterface + ', server returned ' + data);
			});

			document.getElementById('wicd_settings').style.display='none';
			document.getElementById('wicd_settingsSaved').style.display='';
			setTimeout(function(){
				document.getElementById('wicd_settingsSaved').style.display='none';
			}, 1000);
			if(wicd_debugFlag) console.log('event: settings applied');
		});

		/* cancel settings */
		$("#wicd_settingsCancel").click(function(){
			document.getElementById('wicd_settings').style.display='none';
			if(wicd_debugFlag) console.log('event: settings cancelled');
		});

		/* close settings saved */
		$("#wicd_closeSettingsSaved").click(function(){
			document.getElementById('wicd_settingsSaved').style.display='none';
		});

	/* windows - about */

		/* close about window */
		$("#wicd_closeAbout").click(function(){
			document.getElementById('wicd_about').style.display='none';
			if(wicd_debugFlag) console.log('event: about window closed');
		});

	/* windows - add network */

		/* close enter password window */
		$("#wicd_closeEnterPassword").click(function(){
			delete wicd_addNetworkName;
			document.getElementById('wicd_enterPassword').style.display='none';
			if(wicd_debugFlag) console.log('event: password prompt closed');
		});

		/* save network button */
		$("#wicd_saveNetwork").click(function(){
			var password=$('#wicd_enterPasswordText').val();
			if(password != '')
			{
				$.get('<?php echo $_GET['root']; ?>/shell.php?wicd=saveNetwork&networkName=' + wicd_addNetworkName + '&networkPassword=' + password + wicd_csrfToken, function(data){
					if(wicd_debugFlag) console.log('event: wicd_saveNetwork: server returned ' + data);
				});

				$('#wicd_enterPasswordText').val('');
				delete wicd_addNetworkName;
				document.getElementById('wicd_enterPassword').style.display='none';
				document.getElementById('wicd_networkSaved').style.display='';
				setTimeout(function(){
					document.getElementById('wicd_networkSaved').style.display='none';
				}, 1000);

				wicd_getConnectionStatus();
				wicd_getNetworkList();
				if(wicd_debugFlag) console.log('event: network saved');
			}
		});

		/* add network cancel button */
		$("#wicd_saveNetworkCancel").click(function(){
			$('#wicd_enterPasswordText').val('');
			delete wicd_addNetworkName;
			document.getElementById('wicd_enterPassword').style.display='none';
			if(wicd_debugFlag) console.log('event: save network cancelled');
		});

		/* close network saved window */
		$("#wicd_closeNetworkSaved").click(function(){
			document.getElementById('wicd_networkSaved').style.display='none';
			if(wicd_debugFlag) console.log('event: save network closed');
		});


	/* wicd main window */

		/* refresh button */
		$("#wicd_refresh").click(function(){
			if(wicd_debugFlag) console.log('event: refresh button clicked');
			wicd_getConnectionStatus();
			wicd_getNetworkList();
		});

		/* disconnect button */
		$("#wicd_disconnect").click(function(){
			$.get('<?php echo $_GET['root']; ?>/shell.php?wicd=disconnect' + wicd_csrfToken, function(data){
				if(wicd_debugFlag) console.log('event: disconnect button clicked, server returned ' + data);
			});
		});

		/* open settings button */
		$("#wicd_showSettings").click(function(){
			$.get('<?php echo $_GET['root']; ?>/shell.php?wicd=getWifiDevice' + wicd_csrfToken, function(data){
				$('#wicd_settingsWirelessInterface').val(data);
			});

			document.getElementById('wicd_settings').style.display='';
			if(wicd_debugFlag) console.log('event: settings opened');
		});

		/* open about window button */
		$("#wicd_showAbout").click(function(){
			document.getElementById('wicd_about').style.display='';
			if(wicd_debugFlag) console.log('event: about window opened');
		});

		/* add network */
		$(".wicd_addNetwork").click(function(){
			document.getElementById('wicd_enterPassword').style.display='';
			$("#wicd_enterPasswordText").focus();
			if(wicd_debugFlag) console.log('event: add network opened');
		});

		/* connect to network */
		$(".wicd_connectToNetwork").click(function(){
			$.get('<?php echo $_GET['root']; ?>/shell.php?wicd=connect&network=' + wicd_connectToNetworkName + wicd_csrfToken, function(data){
				if(wicd_debugFlag) console.log('event: connect to ' + wicd_connectToNetworkName + ', server returned ' + data);
				wicd_getNetworkList();
			});
		});

		/* autoconnect checkbox */
		$(".wicd_contentNetworksNetworkAutoconnect").change(function(){
			var checkboxname=$(this).attr('name');
			if(this.checked)
				$.get('<?php echo $_GET['root']; ?>/shell.php?wicd=setAutoconnect&state=true&network=' + checkboxname + wicd_csrfToken, function(data){
					if(wicd_debugFlag) console.log('event: contentNetworksNetworkAutoconnect: enabled for ' + checkboxname + ', server returned ' + data);
				});
			else
				$.get('<?php echo $_GET['root']; ?>/shell.php?wicd=setAutoconnect&state=false&network=' + checkboxname + wicd_csrfToken, function(data){
					if(wicd_debugFlag) console.log('event: contentNetworksNetworkAutoconnect: disabled for ' + checkboxname + ', server returned ' + data);
				});
		});

	if(wicd_debugFlag) console.log('defineEvents: events defined');
}

/* get network list */
function wicd_getNetworkList()
{
	if(wicd_debugFlag) console.log('getNetworkList: getting network list...');
	$("#wicd_contentNetworks").html('<div id="wicd_contentNetworksActiontext">Searching...</div>');

	$.get('<?php echo $_GET['root']; ?>/shell.php?wicd=checkWifiDevice' + wicd_csrfToken, function(data){ // check if wifi device is connected
		if(data == 'true')
		{ // download data
			$.getJSON('<?php echo $_GET['root']; ?>/shell.php?wicd=getNetworkList' + wicd_csrfToken, function(data){
				if(data == '') // if no networks available
					$("#wicd_contentNetworks").html('<div id="wicd_contentNetworksActiontext">No networks available</div>');
				else
				{
					var output=''; // output html
					$(data).each(function(index, value){
						if(value.saved == 'true')
						{
							outputButton='<input type="button" class="wicd_connectToNetwork button" name="' + value.name + '" value="Connect" onclick="javascript:wicd_connectToNetworkName=' + "'" + value.name + "'" + '">';
							if(value.autoconnect == 'true')
								autoconnectCheckbox='<input type="checkbox" name="' + value.mac + '" class="wicd_contentNetworksNetworkAutoconnect" checked>Autoconnect<br>';
							else
								autoconnectCheckbox='<input type="checkbox" name="' + value.mac + '" class="wicd_contentNetworksNetworkAutoconnect">Autoconnect<br>';
						}
						else
						{
							outputButton='<input type="button" class="wicd_addNetwork button" name="' + value.name + '" value="Add" onclick="javascript:wicd_addNetworkName=' + "'" + value.name + "'" + '">';
							autoconnectCheckbox='<br>';
						}

						output=output
							+ '<div class="wicd_contentNetworksNetwork">\
								<span class="wicd_contentNetworksNetworkName">'+ value.name + '</span><br>\
								<div class="wicd_contentNetworksNetworkSignalicon">\
									<br>\
									<img src="<?php echo $_GET['icons']; ?>/' + value.qualityImg + '" alt="quality" class="wicd_contentNetworksNetworkSignaliconQualityImg">\
								</div>\
								<div class="wicd_contentNetworksNetworkDetails">'
									+ value.mac + /* ' ' + value.quality + */ ' ' + value.encryption + ' Channel ' + value.channel + '<br>'
									+ autoconnectCheckbox
									+ outputButton
								+ '</div>\
							</div>';
					});
					$("#wicd_contentNetworks").html(output);
				}

				wicd_defineEvents(); // redefine events
				if(wicd_debugFlag) console.log('getNetworkList: network list displayed');
			})
			.fail(function(){ // data download error
				if(wicd_debugFlag) console.log('getNetworkList: server connection failed');
				$("#wicd_contentNetworks").html('<div id="wicd_contentNetworksActiontext">Server connection error</div>');
			});
		}
		else
		{ // wifi device not connected
			if(wicd_debugFlag) console.log('getNetworkList: checkWifiDevice returned false');
			$("#wicd_contentNetworks").html('<div id="wicd_contentNetworksActiontext">Wifi device not connected</div>');
			wicd_defineEvents(); // redefine events
		}
	});
}

/* get connection status */
function wicd_getConnectionStatus()
{
	if(wicd_debugFlag) console.log('getConnectionStatus: started...');
	$('#wicd_status').load('<?php echo $_GET['root']; ?>/shell.php?wicd=getConnectionStatus' + wicd_csrfToken);
	if(wicd_debugFlag) console.log('getConnectionStatus: connection status refreshed');
}