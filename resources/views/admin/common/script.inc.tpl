<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="<{'static/js/excanvas.min.js'|url}>"></script><![endif]-->

<!-- Modernizr (browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support it, eg IE8) -->
<script src="<{'static/js/jquery-2.1.0.min.js'|url}>"></script>
<script>jQuery.noConflict();</script>
<script src="<{'static/js/bootstrap3/bootstrap.min.js'|url}>"></script>
<script src="<{'static/js/noty/jquery.noty.packaged.min.js'|url}>"></script>
<script src="<{'static/js/noty/themes/default.js'|url}>"></script>
<script src="<{'static/js/jquery.slimscroll.min.js'|url}>"></script>
<script src="<{'static/js/common.js'|url}>"></script>
<script src="<{'static/js/magnific-popup/jquery.magnific-popup.min.js'|url}>"></script>
<link rel="stylesheet" href="<{'static/js/magnific-popup/magnific-popup.css'|url}>">
<script src="<{'static/js/proui/app.js'|url}>"></script>
<script type="text/javascript">
(function($){
	var cookie_theme = $.cookie('proui-theme');
	if (cookie_theme)  $('<link id="theme-link" rel="stylesheet" href="' + cookie_theme + '">').appendTo('head');
	$().ready(function(){
		var img_error = function(obj) {
			if (!obj.complete || (typeof obj.naturalWidth !== "undefined" && obj.naturalWidth === 0)) {
				var $img = $(obj);
				var w = $img.width();
				var h = $img.height();
				$img.attr('src', $.baseuri + 'placeholder?text=No+Image' + (w > 0 && h > 0 ? '&size=' + w + 'x' + h : '' ));
			}
		}
		/*$('img').on('error',function(){
			
		});*/
		document.body.addEventListener('error', function(e){
			if (e.target.tagName == 'IMG')
				img_error(e.target);
		}, true);
	});
})(jQuery);
</script>