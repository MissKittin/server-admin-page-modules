<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('index.full.php'); ?>
<?php header('Content-type: text/javascript; charset: UTF-8'); ?>
// Data fetcher
var debug=false;
var loop_sleep=500;

if(debug) console.log('def DOMContentLoaded');
window.addEventListener('DOMContentLoaded', function(){
	// constants
	if(debug) console.log('def constants');
	var dataProvider='<?php echo $system['location_html']; ?>/net-bwusage'; // data fetcher config
	var outputTable=document.getElementById('outputTable');
	var outputTableHeader='<tr><th></th><th>Received</th><th>Transmitted</th></tr>';
	var speed_multiplier=131072; // calculateUtilization() Mb/s * multiplier
	var percentage_multiplier=1000; // calculateUtilization() (in||out/speed)*percentage_multiplier

	// helper
	if(debug) console.log('def getJSON()');
	getJSON=function(url, method, callback, data)
	{
		var xhr=new XMLHttpRequest();
		xhr.open(method, url, true);
		xhr.responseType='json';
		xhr.onload=function() // send response or error to callback function
		{
			var status=xhr.status;
			if(status == 200)
				callback(null, xhr.response);
			else
				callback(status);
		};
		xhr.onerror=function(e){ callback(e);}; // catch network error
		xhr.send(data);
	}

	// create table rows
	if(debug) console.log('def calculateUtilization()');
	function calculateUtilization(info, utilization)
	{
		if(debug) console.log('END --> calculateUtilization(info, utilization)'); if(debug) console.log(info); if(debug) console.log(utilization);

		// info[interface, speed(Mb/s -> B/s), custom name]
		// utilization[in(B/s), out(B/s)]

		/* interface name or label */ if(info[2] == '') var interfaceName=info[0]; else var interfaceName=info[2];
		/* no interface in system? */ if(utilization[1] == 'null') return '<tr><td>' + interfaceName + '</td><td><span class="content_warning">Not connected</span></td></tr>';
		/* speed read error */ if(info[1] == 'null') return '<tr><td>' + interfaceName + '</td><td colspan="2"><span class="content_warning">Unknown speed</span></td></tr>';

		return '<td>' + interfaceName + '</td><td><div class="bar-out"><div class="bar-in" style="width: ' + Math.round((utilization[0]/(info[1]*speed_multiplier))*percentage_multiplier) + 'px;"></div></div></td><td><div class="bar-out"><div class="bar-in" style="width: ' + Math.round((utilization[1]/(info[1]*speed_multiplier))*percentage_multiplier) + 'px;"></div></div></td>';
	}

	// get interfaces utilization and render table
	if(debug) console.log('def getInterfacesData()');
	function getInterfacesData(interfaces, info)
	{
		// interfaces from ?getInterfaces, info from ?getInterfacesInfo
		// queue in interfaces[] always equal queue in info[]
		var interfacesToQuery=''; for(var i=0; i<interfaces.length; i++) interfacesToQuery=interfacesToQuery + '|' + interfaces[i];

		getJSON(dataProvider + '/shell.php?queryInterfaces&interfaces=' + interfacesToQuery, 'get', function(err, response){
			if(err == null)
			{
				var output=outputTableHeader;
				for(var i=0; i<response.length; i++)
					output+='<tr>' + calculateUtilization(info[i], response[i]) + '</tr>';
				outputTable.innerHTML=output;
			}
		});

		// sleep and restart function
		setTimeout(function(){
			if(debug) console.log('getInterfacesData(interfaces, info) <-- START');
			getInterfacesData(interfaces, info)
			if(debug) console.log(interfaces); if(debug) console.log(info);
		}, loop_sleep);
	}

	// get infos about each interface
	if(debug) console.log('def getInterfacesInfo()');
	function getInterfacesInfo(interfaces)
	{
		// interfaces from ?getInterfaces
		var interfacesToQuery=''; for(var i=0; i<interfaces.length; i++) interfacesToQuery=interfacesToQuery + '|' + interfaces[i];

		getJSON(dataProvider + '/shell.php?getInterfacesInfo&interfaces=' + interfacesToQuery, 'get', function(err, response){
			if(err == null) getInterfacesData(interfaces, response);
		});
	}

	// get interfaces to query
	if(debug) console.log('start ?getInterfaces');
	getJSON(dataProvider + '/shell.php?getInterfaces', 'get', function(err, response){
		if(err == null) getInterfacesInfo(response);
	});
});