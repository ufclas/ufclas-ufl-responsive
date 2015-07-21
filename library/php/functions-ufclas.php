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
 * Change the Read More Text from the default
 */
function ufclas_excerpt_more( $more ){
	global $post;
	$custom_meta = get_post_custom($post->ID);
	$custom_button_text = ( isset($custom_meta['custom_meta_featured_content_button_text']) )? $custom_meta['custom_meta_featured_content_button_text'][0]:'';
	$label = ( empty($custom_button_text) )? "Read&nbsp;More":$custom_button_text;
	return '&hellip; <a href="'. get_permalink($post->ID) . '" title="'. get_the_title($post->ID) . '" class="read-more">' . $label . '</a>';   
}

add_filter('excerpt_more', 'ufclas_excerpt_more');
add_filter('the_content_more_link', 'ufclas_excerpt_more');

/**
 * Show either the_content or the_excerpt based on whether post contains the <!--more--> tag
 */
function ufclas_teaser_excerpt( $excerpt ){
	global $post;
	$has_teaser = (strpos($post->post_content, '<!--more') !== false);
	if ($has_teaser){
		// Remove extra formatting from the content
		return strip_tags( get_the_content(), '<a><br>' );
	}
	else {
		return $excerpt;	
	}
}

add_filter( 'get_the_excerpt', 'ufclas_teaser_excerpt');

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

/**
 * Show additional sizes in the insert image dialog
 */
function ufclas_show_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
		'page_header' => __( 'Page Header' ),
    ) );
}
add_filter( 'image_size_names_choose', 'ufclas_show_custom_sizes' );

/**
 * Adds Widgets in Homepage Feature Area
 **/
function ufclas_responsive_featured_widget_area() {
		
		$ufclas_responsive_home_featured_widgets = of_get_option("opt_home_featured_widgets");
		
		if($ufclas_responsive_home_featured_widgets){
			echo '<div id="featured-widget-right">';
		
			get_sidebar('home_featured_right');
		
			echo "</div><!-- end #featured-widget-right -->";
		}
}

// Homepage Featured Widget
function ufclas_responsive_widgets_init() {
    
	$ufclas_responsive_home_featured_widgets = of_get_option("opt_home_featured_widgets");
	
	if ($ufclas_responsive_home_featured_widgets) {
		register_sidebar (array(
			'name' => 'Home Featured Right',
			'id' => 'home_featured_right',
			'description' => 'Widgets in this area will be shown in the Header Featured area.',
			'before_widget' => '<div class="widget home_widget">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));
	}
}
add_action( 'widgets_init', 'ufclas_responsive_widgets_init' );