<?php
/**************************************************************
 *                                                            *
 *   Provides a notification to the user everytime            *
 *   your WordPress theme is updated                          *
 *                                                            *
 *   Author: Joao Araujo                                      *
 *   Profile: http://themeforest.net/user/unisphere           *
 *   Follow me: http://twitter.com/unispheredesign            *
 *                                                            *
 **************************************************************/

// Constants for the theme name, folder and remote XML url
define( 'NOTIFIER_THEME_NAME', 'UF Template Responsive' ); // The theme name
define( 'NOTIFIER_THEME_FOLDER_NAME', array_pop(explode( '/', get_bloginfo('template_directory') ) ) ); // The theme folder name
define( 'NOTIFIER_XML_FILE', 'http://webservices.it.ufl.edu/uf-template-notifier.xml' ); // The remote notifier XML file containing the latest version of the theme and changelog
define( 'NOTIFIER_CACHE_INTERVAL', 604800 ); // The time interval for the remote XML cache in the database (21600 seconds = 6 hours)

// Adds an update notification to the WordPress Dashboard menu
function update_notifier_menu() {  
	if (function_exists('simplexml_load_string')) { // Stop if simplexml_load_string funtion isn't available
		$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
		$theme_data = wp_get_theme(); // Read theme current version from the style.css
		if( (float)$xml->latest > (float)$theme_data['Version']) { // Compare current theme version with the remote XML version
			add_theme_page( NOTIFIER_THEME_NAME . ' Information - Updates Available', 'Theme Info' . ' <span class="update-plugins count-1"><span class="update-count">Updates</span></span>', 'administrator', 'theme-update-notifier', 'update_notifier');
			add_action('admin_notices', 'ufl_template_update_notice');
		} else {
			add_theme_page( NOTIFIER_THEME_NAME . ' Information', 'Theme Info', 'administrator', 'theme-update-notifier', 'update_notifier');
		}
	}	
}
add_action('admin_menu', 'update_notifier_menu');  

// Adds an update notification to the WordPress 3.1+ Admin Bar
function update_notifier_bar_menu() {
	if (function_exists('simplexml_load_string')) { // Stop if simplexml_load_string funtion isn't available
		global $wp_admin_bar, $wpdb;
	
		if ( !is_super_admin() || !is_admin_bar_showing() ) // Don't display notification in admin bar if it's disabled or the current user isn't an administrator
		return;
		
		$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
		$theme_data = wp_get_theme(); // Read theme current version from the style.css
	
		if( (float)$xml->latest > (float)$theme_data['Version']) { // Compare current theme version with the remote XML version
			$wp_admin_bar->add_menu( array( 'id' => 'update_notifier', 'title' => '<span>' . NOTIFIER_THEME_NAME . ' <span id="ab-updates">Updates</span></span>', 'href' => get_admin_url() . 'themes.php?page=theme-update-notifier' ) );
		}
	}
}
add_action( 'admin_bar_menu', 'update_notifier_bar_menu', 1000 );



// The notifier page
function update_notifier() { 
	$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
	$theme_data = wp_get_theme(); // Read theme current version from the style.css ?>
	
	<style>
		.update-nag { display: none; }
		#instructions {max-width: 670px;}
		h3.title {margin: 30px 0 0 0; padding: 30px 0 0 0; border-top: 1px solid #ddd;}
	</style>

	<div class="wrap">
	
		<div id="icon-tools" class="icon32"></div>
		<h2><?php echo NOTIFIER_THEME_NAME; ?> Information</h2>
		<!--<div id="message" class="updated below-h2"><p><strong>There is a new version of the <?php echo NOTIFIER_THEME_NAME; ?> available.</strong> You have version <?php echo $theme_data['Version']; ?> installed. Update to version <?php echo $xml->latest; ?>.</p></div>-->

		<div id="instructions">

			<img style="float: left; margin: 0 20px 20px 0; border: 1px solid #ddd;" src="<?php echo get_bloginfo( 'template_url' ) . '/screenshot.png'; ?>" />
			<h3>Theme Information</h3>
			<p>Please see the changelog below for information about the theme.</p>

			<?php if( (float)$xml->latest > (float)$theme_data['Version']) { ?>
			<h3>Update Information</h3>
			<p><strong>There is a new version of the <?php echo NOTIFIER_THEME_NAME; ?> available.</strong></p>
			<p>You have version <?php echo $theme_data['Version']; ?> installed. Update to version <strong><?php echo $xml->latest; ?></strong>.</p>
			<h3>Update Download and Instructions</h3>
			<p><strong>Please note:</strong> make a <strong>backup</strong> of the Theme inside your WordPress installation folder <strong>/wp-content/themes/<?php echo NOTIFIER_THEME_FOLDER_NAME; ?>/</strong></p>
			<p>To download the updated <?php echo NOTIFIER_THEME_NAME; ?>, please visit the <a href="http://webservices.it.ufl.edu">UF Web Services</a> site.</p>

			<ol>
				<li>Extract the zip's contents.</li>
				<li>Upload the files to a new folder in <strong>/wp-content/themes/</strong>.</li>
				<li>Update any files that you have customized.</li>
				<li>Log in to WordPress and switch to the new theme.</li>
				<li>Check that your site is functioning correctly.</li>
				<li>Archive and remove the old theme folder.</li>
			</ol>

			<p>If you have edited any files please ensure that your changes are not being overwritten.</p>
			<?php } ?>
			<div class="clear"></div>
		</div>
		
		<h3 class="title">Changelog</h3>
		<?php echo $xml->changelog; ?>

	</div>
	
<?php } 

// Get the remote XML file contents and return its data (Version and Changelog)
// Uses the cached version if available and inside the time interval defined
function get_latest_theme_version($interval) {
	$notifier_file_url = NOTIFIER_XML_FILE;	
	$db_cache_field = 'notifier-cache';
	$db_cache_field_last_updated = 'notifier-cache-last-updated';
	$last = get_option( $db_cache_field_last_updated );
	$now = time();
	// check the cache
	if ( !$last || (( $now - $last ) > $interval) ) {
		// cache doesn't exist, or is old, so refresh it
		if( function_exists('curl_init') ) { // if cURL is available, use it...
			$ch = curl_init($notifier_file_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$cache = curl_exec($ch);
			curl_close($ch);
		} else {
			$cache = file_get_contents($notifier_file_url); // ...if not, use the common file_get_contents()
		}
		
		if ($cache) {			
			// we got good results	
			update_option( $db_cache_field, $cache );
			update_option( $db_cache_field_last_updated, time() );
		} 
		// read from the cache file
		$notifier_data = get_option( $db_cache_field );
	}
	else {
		// cache file is fresh enough, so read from it
		$notifier_data = get_option( $db_cache_field );
	}
	
	// Let's see if the $xml data was returned as we expected it to.
	// If it didn't, use the default 1.0 as the latest version so that we don't have problems when the remote server hosting the XML file is down
	if( strpos((string)$notifier_data, '<notifier>') === false ) {
		$notifier_data = '<?xml version="1.0" encoding="UTF-8"?><notifier><latest>1.0</latest><changelog></changelog></notifier>';
	}
	
	// Load the remote XML data into a variable and return it
	$xml = simplexml_load_string($notifier_data); 
	
	return $xml;
}

function ufl_template_update_notice(){
	global $pagenow;
	global $current_user;
	$user_id = $current_user->ID;

	/* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'ufl_update_ignore') ) {
		if ( $pagenow == 'themes.php' || $pagenow == 'index.php' ) {
			 echo '<div class="updated"><p>';
			 printf(__('<strong>There is a new version of the '.NOTIFIER_THEME_NAME.' available.</strong> <a href="' . get_admin_url() . 'themes.php?page=theme-update-notifier">Learn More</a> | <a href="%1$s">Hide Notice</a>'), '?ufl_update_ignore=0');
			 echo '</p></div>';
		}
	}
}

add_action('admin_init', 'ufl_update_ignore');
function ufl_update_ignore() {
	global $current_user;
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset($_GET['ufl_update_ignore']) && '0' == $_GET['ufl_update_ignore'] ) {
			 add_user_meta($user_id, 'ufl_update_ignore', 'true', true);
			 //delete_user_meta($user_id, 'ufl_update_ignore', 'true', true); //uncomment to delete for debugging
	}
}

?>
