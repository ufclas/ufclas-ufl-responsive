<?php 
/**
 * Display login messages for restricted pages
 */
if ( ufl_check_page_visitor_level($post->ID) > 0 ) {
	
	// Display a login message, depending on login status
	if( !ufl_shibboleth_valid_user() ){
		// User has not logged in
		?>
		<h2>Protected</h2>
		<p>This content can only be seen by authorized users. Please login by clicking the button below.</p>
		<?php
	}
	else {
		// If logged in and denied access
		$webmaster_email = of_get_option("opt_webmaster_email");
		$site_admin = (empty($webmaster_email))? "site administrator" : "<a href=\"mailto:{$webmaster_email}\">site administrator</a>";
		?>
		<h2>Access Denied</h2>
		<p>Sorry, you do not have permission to view this page.Please contact the <?php echo $site_admin; ?> if you have questions about accessing this content.</p>				
		<?php	
	}
	
	// Display the correct login button
	if( ufl_check_page_visitor_level($post->ID) >= 2 ){
		// GatorLink logins
		ufl_shibboleth_login_button();
	}
	else {
		// WordPress login
		?>
		<p><a href="<?php echo wp_login_url( get_permalink($post->ID) ); ?>" class="button" title="Login">WordPress Login</a></p>
        <?php
	}
}
	
	
	
	