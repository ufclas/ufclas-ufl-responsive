<?php 
	$webmaster_email = of_get_option("opt_webmaster_email");
	$site_admin = (empty($webmaster_email))? "site administrator" : "<a href=\"mailto:" . sanitize_email($webmaster_email) . "\">site administrator</a>";
?>
  	<h2 class="medium-blue">Sorry, you do not have permission to view this page.</h2>
  	<p>Please contact the <?php echo $site_admin; ?> if you have questions about accessing this content. 
    <p><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></p>
