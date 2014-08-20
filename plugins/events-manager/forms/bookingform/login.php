<?php
/* 
 * This file generates the default login form within the booking form (if enabled in options).
 */
?>
<div class="em-booking-login">
	<form class="em-booking-login-form" action="<?php echo site_url('wp-login.php', 'login_post'); ?>" method="post">
	<p><?php esc_html_e('Log in with your GatorLink account.','dbem'); ?></p>
    
	<?php do_action('login_form'); ?>
	<input type="submit" name="wp-submit" id="em_wp-submit" value="<?php esc_html_e('Log In', 'dbem'); ?>" tabindex="100" />
	<input type="hidden" name="redirect_to" value="<?php echo esc_url($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']); ?>#em-booking" />
	
    </form>
  
</div>