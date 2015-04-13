<?php

/**
 * Display social network links only if they are set in the theme options, ignores the parent organization
 */

function ufclas_get_site_socialnetworks() {
	$social_networks = array(
		'facebook' => 'Facebook',
		'twitter' => 'Twitter',
		'youtube' => 'YouTube',
	);
	
	foreach( $social_networks as $name => $title ){
		$link = of_get_option("opt_{$name}_url");
		if( !empty($link) ){
			echo "<li><a href=\"{$link}\" class=\"{$name} ir\" title=\"{$title}\">{$title}</a></li>";
		}
	}
}

/**
 * The Events Calendar functions 
 */
function ufclas_events_widget_before_title(){
	global $post;
	
	// Change format of the start date for styling as an icon
	$tribe_post_month = tribe_get_start_date( $post, false, 'M' );
	$tribe_post_day = tribe_get_start_date( $post, false, 'j' );
	?>
    
    <div class="event-date">
    	<span class="event-month"><?php echo $tribe_post_month; ?></span>
        <span class="event-day"><?php echo $tribe_post_day; ?></span>
   	</div>
    
    <?php 
}
add_action( 'tribe_events_list_widget_before_the_event_title', 'ufclas_events_widget_before_title' );
