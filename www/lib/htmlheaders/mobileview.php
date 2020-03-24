<?php // mobile view mod, 31.10.2019, 02.11.2019, minified 20.03.2020 ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--[if !IE]><!--><script>
document.addEventListener('DOMContentLoaded', function(){
	if(window.outerWidth < 600 && document.getElementById('system_menu') != null)
	{
		var useAnimations=true;

		document.getElementById('system_menu').style.display='none';
		//document.getElementById('system_menu').style.float='none';

		var system_content_marginLeft=window.getComputedStyle(document.getElementById('system_content'));
		var system_content_marginLeft=system_content_marginLeft.marginLeft;
		window.system_content_marginLeftInt=system_content_marginLeft.substring(0, system_content_marginLeft.length - 2);
		document.getElementById('system_content').style.marginLeft='0';

		var system_menuButtonDiv=document.createElement('div');
		system_menuButtonDiv.style.margin='10px';

		if(useAnimations)
			system_menuButtonDiv.innerHTML='<div id="mobileview_about" style="display: none; \
									margin: 0px; \
									position: absolute; \
									top: 0; bottom: 0; left: 0; \
									width: 100%; height: 100%; \
									background-color: var(--content_background-color); \
							"> \
					<h1 style="text-align: center;">MobileView v1.1</h1> \
					<div style="text-align: center;"> \
						adapts the layout to mobile device<br> \
						designed for <a style="text-decoration: none; color: var(--content_text-color);" target="_blank" href="https://github.com/MissKittin/server-admin-page">server-admin-page</a><br> \
						31.10.2019, 02.11.2019<br> \
						<a style="text-decoration: none; color: var(--content_text-color);" target="_blank" href="https://github.com/MissKittin">MissKittin@GitHub</a> \
					</div> \
					<div style="-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; \
							border: solid 1px #20538D; \
							text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4); -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); \
							background: #4479BA; \
							color: #FFF; \
							padding: 8px 12px; \
							text-decoration: none; \
							text-align: center; \
							position: absolute; \
							bottom: 10px; \
							left: 2px; right: 2px; \
						" onclick=" \
							aboutOpacity=1; \
							function animateAboutOut() \
							{ \
								setTimeout(function(){ \
									if(aboutOpacity > 0) \
									{ \
										aboutOpacity=aboutOpacity-0.05; \
										document.getElementById(' + "'" + 'mobileview_about' + "'" + ').style.opacity=aboutOpacity; \
										animateAboutOut(); \
									} \
									else \
									{ \
										document.getElementById(' + "'" + 'mobileview_about' + "'" + ').style.opacity=' + "'" + '0' + "'" + ';  \
										getElementById(' + "'" + 'mobileview_about' + "'" + ').style.display=' + "'" + 'none' + "'" + '; \
										document.body.style.overflow=' + "'" + 'visible' + "'" + '; \
									} \
								}, 1); \
							} \
							animateAboutOut(); \
						"> \
						OK \
					</div> \
				</div> \
				<button id="mobileview_menuButton" class="system_button" onclick=" \
									if(document.getElementById(' + "'" + 'system_menu' + "'" + ').style.display == ' + "'" + 'none' + "'" + ') \
									{ \
										var marginLeft=0; \
										var menuOpacity=0; \
										function animateMenu() \
										{ \
											setTimeout(function(){ \
												if(menuOpacity < 1) \
												{ \
													menuOpacity=menuOpacity+0.08; \
													document.getElementById(' + "'" + 'system_menu' + "'" + ').style.opacity=menuOpacity; \
													animateMenu(); \
												} \
												else \
													document.getElementById(' + "'" + 'system_menu' + "'" + ').style.opacity=' + "'" + '1' + "'" + ';  \
											}, 1); \
										} \
										function animateContent() \
										{ \
											setTimeout(function(){ \
												if(marginLeft < system_content_marginLeftInt) \
												{ \
													marginLeft=marginLeft+6; \
													document.getElementById(' + "'" + 'system_content' + "'" + ').style.marginLeft=marginLeft+' + "'" + 'px' + "'" + '; \
													animateContent(); \
												} \
												else \
												{ \
													document.getElementById(' + "'" + 'system_content' + "'" + ').style.marginLeft=' + "'" + system_content_marginLeftInt + 'px' + "'" + '; \
													document.getElementById(' + "'" + 'system_menu' + "'" + ').style.opacity=menuOpacity; \
													document.getElementById(' + "'" + 'system_menu' + "'" + ').style.display=' + "''" + '; \
													animateMenu(); \
												} \
											}, 1); \
										} \
										animateContent(); \
									} \
									else \
									{ \
										var marginLeft=system_content_marginLeftInt; \
										var menuOpacity=1; \
										function animateContent() \
										{ \
											setTimeout(function(){ \
												if(marginLeft > 0) \
												{ \
													marginLeft=marginLeft-6; \
													document.getElementById(' + "'" + 'system_content' + "'" + ').style.marginLeft=marginLeft+' + "'" + 'px' + "'" + '; \
													animateContent(); \
												} \
												else \
													document.getElementById(' + "'" + 'system_content' + "'" + ').style.marginLeft=' + "'" + '0px' + "'" + '; \
											}, 1); \
										} \
										function animateMenu() \
										{ \
											setTimeout(function(){ \
												if(menuOpacity > 0.01) \
												{ \
													menuOpacity=menuOpacity-0.08; \
													document.getElementById(' + "'" + 'system_menu' + "'" + ').style.opacity=menuOpacity; \
													animateMenu(); \
												} \
												else \
												{ \
													document.getElementById(' + "'" + 'system_menu' + "'" + ').style.opacity=' + "'" + '0' + "'" + ';  \
													document.getElementById(' + "'" + 'system_menu' + "'" + ').style.display=' + "'none'" + '; \
													animateContent(); \
												} \
											}, 1); \
										} \
										animateMenu(); \
									} \
								" \
				>Menu</button> \
				<span style="color: var(--content_background-color); \
						text-shadow: -1px 0 var(--content_border-color), 0 1px var(--content_border-color), 1px 0 #aaaaaa, 0 -1px var(--content_border-color); \
						vertical-align: middle; \
					" onclick=" \
							document.body.style.overflow=' + "'" + 'hidden' + "'" + '; \
							getElementById(' + "'" + 'mobileview_about' + "'" + ').style.opacity=' + "'" + '0' + "'" + '; \
							getElementById(' + "'" + 'mobileview_about' + "'" + ').style.display=' + "'" + 'block' + "'" + '; \
							aboutOpacity=0; \
							function animateAboutIn() \
							{ \
								setTimeout(function(){ \
									if(aboutOpacity < 1) \
									{ \
										aboutOpacity=aboutOpacity+0.05; \
										document.getElementById(' + "'" + 'mobileview_about' + "'" + ').style.opacity=aboutOpacity; \
										animateAboutIn(); \
									} \
									else \
										document.getElementById(' + "'" + 'mobileview_about' + "'" + ').style.opacity=' + "'" + '1' + "'" + ';  \
						}, 1); \
							} \
							animateAboutIn(); \
					" \
				>MobileView</span>';
		else
			system_menuButtonDiv.innerHTML='<div id="mobileview_about" style="display: none; \
												margin: 0px; \
												position: absolute; \
												top: 0; bottom: 0; left: 0; \
												width: 100%; height: 100%; \
												background-color: var(--content_background-color); \
										"> \
								<h1 style="text-align: center;">MobileView v1</h1> \
								<div style="text-align: center;"> \
									adapts the layout to mobile device<br> \
									designed for <a style="text-decoration: none; color: var(--content_text-color);" target="_blank" href="https://github.com/MissKittin/server-admin-page">server-admin-page</a><br> \
									31.10.2019, 02.11.2019<br> \
									<a style="text-decoration: none; color: var(--content_text-color);" target="_blank" href="https://github.com/MissKittin">MissKittin@GitHub</a> \
								</div> \
								<div style="-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; \
										border: solid 1px #20538D; \
										text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4); -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); \
										background: #4479BA; \
										color: #FFF; \
										padding: 8px 12px; \
										text-decoration: none; \
										text-align: center; \
										position: absolute; \
										bottom: 10px; \
										left: 2px; right: 2px; \
									" onclick=" \
										getElementById(' + "'" + 'mobileview_about' + "'" + ').style.display=' + "'" + 'none' + "'" + '; \
										document.body.style.overflow=' + "'" + 'visible' + "'" + '; \
									"> \
									OK \
								</div> \
							</div> \
							<button id="mobileview_menuButton" class="system_button" onclick="if(document.getElementById(' + "'" + 'system_menu' + "'" + ').style.display == ' + "'" + 'none' + "'" + ') \
												{ \
													document.getElementById(' + "'" + 'system_content' + "'" + ').style.marginLeft=' + "'" + system_content_marginLeft + "'" + '; \
													document.getElementById(' + "'" + 'system_menu' + "'" + ').style.display=' + "''" + '; \
												} \
												else \
												{ \
													document.getElementById(' + "'" + 'system_menu' + "'" + ').style.display=' + "'none'" + '; \
													document.getElementById(' + "'" + 'system_content' + "'" + ').style.marginLeft=' + "'" + '0px' + "'" + '; \
												}"\
							>Menu</button> \
							<span style="color: var(--content_background-color); \
									text-shadow: -1px 0 var(--content_border-color), 0 1px var(--content_border-color), 1px 0 #aaaaaa, 0 -1px var(--content_border-color); \
									vertical-align: middle; \
								" onclick="document.body.style.overflow=' + "'" + 'hidden' + "'" + '; \
										getElementById(' + "'" + 'mobileview_about' + "'" + ').style.display=' + "'" + 'block' + "'" + ';" \
							>MobileView</span>';

		var system_menuButton=document.getElementById('system_body');
		system_menuButton.insertBefore(system_menuButtonDiv, system_menuButton.childNodes[0]);

		document.getElementById('mobileview_about').addEventListener('touchmove', function(e){
			e.preventDefault();
		}, false);
	}
});
</script><!--<![endif]-->
