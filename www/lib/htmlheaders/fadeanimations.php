<?php
	// fade-in/out animations
	// 04.11.2019
?>
<!--[if !IE]><!-->
<style>
	body {
		opacity: 0;
	}
</style>
<script>
	/* load animation */
	document.addEventListener('DOMContentLoaded', function(){
		var bodyOpacity=0;
		function animate()
		{
			setTimeout(function(){
				if(bodyOpacity < 1)
				{
					bodyOpacity=bodyOpacity+0.08;
					document.body.style.opacity=bodyOpacity;
					animate();
				}
				else
					document.body.style.opacity=1;
			}, 1);
		}
		animate();
	});

	/* exit animation */
	window.onbeforeunload=function(){
		var bodyOpacity=1;
		function animate()
		{
			setTimeout(function(){
				if(bodyOpacity > 0.01)
				{
					bodyOpacity=bodyOpacity-0.05;
					document.body.style.opacity=bodyOpacity;
					animate();
				}
				else
					document.body.style.opacity=0;
			}, 1);
		}
		animate();
	};
</script>
<!--<![endif]-->
