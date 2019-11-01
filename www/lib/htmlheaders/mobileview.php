<?php // mobile view mod, 31.10.2019 ?>
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
			system_menuButtonDiv.innerHTML='<button class="system_button" onclick="if(document.getElementById(' + "'" + 'system_menu' + "'" + ').style.display == ' + "'" + 'none' + "'" + ') { document.getElementById(' + "'" + 'system_content' + "'" + ').style.marginLeft=' + "'" + system_content_marginLeft + "'" + '; document.getElementById(' + "'" + 'system_menu' + "'" + ').style.display=' + "''" + '; } else { document.getElementById(' + "'" + 'system_menu' + "'" + ').style.display=' + "'none'" + '; document.getElementById(' + "'" + 'system_content' + "'" + ').style.marginLeft=' + "'" + '0px' + "'" + '; }">Menu</button> <span style="color: var(--content_background-color); text-shadow: -1px 0 var(--content_border-color), 0 1px var(--content_border-color), 1px 0 #aaaaaa, 0 -1px var(--content_border-color);">MobileView v1</button>';
			var system_menuButton=document.getElementById('system_body');
			system_menuButton.insertBefore(system_menuButtonDiv, system_menuButton.childNodes[0]);
	}
});
</script><!--<![endif]-->
