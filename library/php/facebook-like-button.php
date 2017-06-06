<?php
/**
 * Facebook Like Button
 *
 * Adds Like/Share button to share posts on Facebook. 
 * Uses small button size with button_count layout.
 *
 * @link https://developers.facebook.com/docs/plugins/like-button
 * @since 0.8.9
 */
?>
<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
