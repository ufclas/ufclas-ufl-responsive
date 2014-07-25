<?php

/* Register Subpage Excerpt List. */

function subpage_peek($atts, $content = null) {  
	global $post;

	// Extract shortcode arguements
	extract(shortcode_atts(array(
		'order' => 'asc',
		'orderby' => 'menu_order',
		'numpages' => '-1',
		'hidethumb' => 'false',
		'removelinks' => 'false',
		'showfullcontent' => 'false'
	), $atts));

	//query subpages  
	$args = array(  
		'post_parent' => $post->ID,  
		'post_type' => 'page',
		'order' => $order,
		'orderby' => $orderby,
		'posts_per_page' => $numpages
	);  
	$subpages = new WP_query($args);  
	$i = 1;
	// create output  
	if ($subpages->have_posts()) :  
		$output = '<div id="subpage-list">';  
		while ($subpages->have_posts()) : $subpages->the_post();
			$output .= '<hr /><div class="entry" id="subpage-link-'.$i.'">';
			if ( $hidethumb == 'false' && has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
	  			$output .= '<a href="'.get_permalink().'" class="alignleft">'.get_the_post_thumbnail($post->ID, 'thumbnail', array('class' => 'wp-post-image')).'</a>';
			}
	  		$output .= '<h3>';
	  		$output .= ( $removelinks == 'true' ? get_the_title() : '<a href="'.get_permalink().'">'.get_the_title().'</a>' );
	  		$output .= '</h3><p>';
	  		$output .= ( $showfullcontent == 'true' ? get_the_content() : get_the_excerpt() );

			if ( $removelinks == 'false' ) { $output .= '<br /><a href="'.get_permalink().'"><em>Read more &raquo;</em></a>'; } 
			$output .= '</p>
				</div>';  
			$i++;
		endwhile;  
		$output .= '<div style="clear:both;"></div>'; 
		$output .= '</div>'; 
	else :  
		$output = '<p>No subpages found.</p>';  
	endif;

	// reset the query  
	wp_reset_postdata();
  
	// return something  
	return $output;  
}  

add_shortcode('subpage_peek', 'subpage_peek');  


?>