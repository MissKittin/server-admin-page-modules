<?php // mobile view mod, 31.10.2019, 02.11.2019 ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--[if !IE]><!--><script>
document.addEventListener('DOMContentLoaded', function(){
	if(window.outerWidth < 600 && document.getElementById('system_menu') != null)
	{
		document.getElementById('system_menu').style.display='none';
		//document.getElementById('system_menu').style.float='none';

		var system_content_marginLeft=window.getComputedStyle(document.getElementById('system_content'));
		var system_content_marginLeft=system_content_marginLeft.marginLeft;
		document.getElementById('system_content').style.marginLeft='0px';

		var system_menuButtonDiv=document.createElement('div');
		system_menuButtonDiv.style.margin='10px';
		system_menuButtonDiv.innerHTML='<div id="mobileview_about" style="display: none; margin: 0px; position: absolute; top: 0; bottom: 0; left: 0; width: 100%; height: 100%; background-color: var(--content_background-color);"><h1 style="text-align: center;">MobileView v1</h1><div style="text-align: center;">adapts the layout to mobile device<br>designed for <a style="text-decoration: none; color: var(--content_text-color);" target="_blank" href="https://github.com/MissKittin/server-admin-page">server-admin-page</a><br>31.10.2019, 02.11.2019<br><a style="text-decoration: none; color: var(--content_text-color);" target="_blank" href="https://github.com/MissKittin">MissKittin@GitHub</a></div><div style="-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; border: solid 1px #20538D; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4); -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); background: #4479BA; color: #FFF; padding: 8px 12px; text-decoration: none; text-align: center; position: absolute; bottom: 10px; right: 10px;" onclick="getElementById(' + "'" + 'mobileview_about' + "'" + ').style.display=' + "'" + 'none' + "'" + '; document.body.style.overflow=' + "'" + 'visible' + "'" + ';">OK</div></div><button class="system_button" onclick="if(document.getElementById(' + "'" + 'system_menu' + "'" + ').style.display == ' + "'" + 'none' + "'" + ') { document.getElementById(' + "'" + 'system_content' + "'" + ').style.marginLeft=' + "'" + system_content_marginLeft + "'" + '; document.getElementById(' + "'" + 'system_menu' + "'" + ').style.display=' + "''" + '; } else { document.getElementById(' + "'" + 'system_menu' + "'" + ').style.display=' + "'none'" + '; document.getElementById(' + "'" + 'system_content' + "'" + ').style.marginLeft=' + "'" + '0px' + "'" + '; }">Menu</button> <span style="color: var(--content_background-color); text-shadow: -1px 0 var(--content_border-color), 0 1px var(--content_border-color), 1px 0 #aaaaaa, 0 -1px var(--content_border-color);" onclick="document.body.style.overflow=' + "'" + 'hidden' + "'" + '; getElementById(' + "'" + 'mobileview_about' + "'" + ').style.display=' + "'" + 'block' + "'" + ';">MobileView v1</span>';
		var system_menuButton=document.getElementById('system_body');
		system_menuButton.insertBefore(system_menuButtonDiv, system_menuButton.childNodes[0]);

		var mobileview_about_scroll=document.getElementById('mobileview_about');
		mobileview_about_scroll.addEventListener('touchmove', function(e){
			e.preventDefault();
		}, false);
	}
});
</script><!--<![endif]-->
