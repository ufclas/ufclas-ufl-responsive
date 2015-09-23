<?php
/*-----------------------------------------------------------------------------------*/
/*	Custom ShortCodes
/*-----------------------------------------------------------------------------------*/
include_once('shortcode-people-listing.php');
include_once('shortcode-subpage-peek.php');
include_once('shortcode-attachment-list.php');


/* ----------------------------------------------------------------------------------- */
/* Insert a widget via a shortcode
/*
/* courtesy of: http://digwp.com/2010/04/call-widget-with-shortcode/
/* modified to allow the passing of attributes
/* [widget widget_name="Your_Custom_Widget"]
/* ----------------------------------------------------------------------------------- */
function ufandshands_widget_shortcode($atts) {
    
    global $wp_widget_factory;
    
    extract(shortcode_atts(array(
        'widget_name' => FALSE, // specific class name of shortcode
		'title' => '', // universal to all widgets
		'numberofposts' => '3', // recent posts
		'showexcerpt' => 1, // recent posts
		'showthumbnails' => 1, // recent posts
		'showdate' => 1, // recent posts
		'showrssicon' => 1, // recent posts
		'specific_category_id' => ''
    ), $atts));
    
    $widget_name = wp_specialchars($widget_name);
    
    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
	
        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));
        
        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;
    
	$instance = '&title='.$title;
	$instance .= '&numberofposts='.$numberofposts;
	$instance .= '&showexcerpt='.$showexcerpt;
	$instance .= '&showthumbnails='.$showthumbnails;
	$instance .= '&showdate='.$showdate;
	$instance .= '&showrssicon='.$showrssicon;
	$instance .= '&specific_category_id='.$specific_category_id;
		// $instance .= '&='.$;	
	
    ob_start();
	the_widget($widget_name, $instance, array('widget_id'=>'arbitrary-instance-'.$id,
		'before_widget' => '<div class="widget_body">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
				
	));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
    
}
add_shortcode('widget','ufandshands_widget_shortcode'); 




// flowerplayer&video shortcode -- not using the extra attribute yet, leaving as template
function ufandshands_flow_func($atts, $content = null) {
	extract(shortcode_atts(array(
		'foo' => 'something',
		'bar' => 'something else',
	), $atts));

	// iPad plugin wont play nice with multiple players on screen, so use a splash image to trigger default flowplayer ipad/iphone behavior
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('/ipod/i',$user_agent)>0 || preg_match('/iphone/i',$user_agent)>0 || preg_match('/ipad/i',$user_agent)>0 || preg_match('/android/i',$user_agent)>0 || preg_match('/opera mini/i',$user_agent)>0 ) {
		$user_agent = "<img src=\"http://med.ufl.edu/video/ufcomsplash.jpg\"";
	} else { $user_agent = ""; }

	// build flowjava return
	$flowjava = "<script type=\"text/javascript\" src=\"/flowplayer/flowplayer-3.2.6.min.js\"></script><script type=\"text/javascript\" src=\"/flowplayer/flowplayer.ipad-3.2.2.min.js\"></script>";
	$flowjava .="	<a  	class=\"player\"
				href=\"".$content."\"
				style=\"display:block;width:100%;height:470px;\"  
				>".$user_agent."
			</a>";
	$flowjava .="	<script>
				flowplayer(\"a.player\", {src: \"/flowplayer/flowplayer-3.2.7.swf\", wmode: 'opaque' }, {
					clip:  {
                				autoPlay: false,
               					autoBuffering: true,
						scaling: 'orig'
                			}
                		}).ipad(\"a.player\");
			</script>";
	return $flowjava;
}
add_shortcode('video', 'ufandshands_flow_func');
add_shortcode('flv', 'ufandshands_flow_func');



// custom vimeo embed -- disabled 6-25-2011 -- WordPress' own oembed function now supports vimeo
// function orange_and_blue_vimeo_func($atts, $content = null) {
	// extract(shortcode_atts(array(
		// 'foo' => 'something',
		// 'bar' => 'something else',
	// ), $atts));

	// if (preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $content, $match)) {
    		// $vimeo_id = $match[1];
	// } else { return "Please use the following format for Vimeo videos: http://vimeo.com/7573098"; }

	// $vimeo_embed = "<object width=\"100%\" height=\"470\"><param name=\"allowfullscreen\" value=\"true\" /><param name=\"allowscriptaccess\" value=\"always\" /><param name=\"movie\" value=\"http://vimeo.com/moogaloop.swf?clip_id=".$vimeo_id."&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=00ADEF&amp;fullscreen=1&amp;autoplay=0&amp;loop=0\" /><embed src=\"http://vimeo.com/moogaloop.swf?clip_id=".$vimeo_id."&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=00ADEF&amp;fullscreen=1&amp;autoplay=0&amp;loop=0\" type=\"application/x-shockwave-flash\" allowfullscreen=\"true\" allowscriptaccess=\"always\" width=\"100%\" height=\"470\"></embed></object>";

	// return $vimeo_embed;
// }
// add_shortcode('vimeo', 'orange_and_blue_vimeo_func');


// split content into two columns

function ufandshands_shortcode_float_left($atts, $content = null) {
	extract(shortcode_atts(array(
                'autop' => '1',
	), $atts));

	$content = do_shortcode($content);

	$left_float = "<div class='shortcode_alignleft'>";
        if ($autop=='1')
            $left_float .= wpautop($content);
        else
            $left_float .= $content;
        
	$left_float .= "</div>";

	return $left_float;
}
add_shortcode('left', 'ufandshands_shortcode_float_left');

function ufandshands_shortcode_float_right($atts, $content = null) {
	extract(shortcode_atts(array(
                'autop' => '1',
	), $atts));
	$content = do_shortcode($content);

	$right_float = "<div class='shortcode_alignright'>";
        if ($autop=='1')
            $right_float .= wpautop($content);
        else
            $right_float .= $content;
            
	$right_float .= "</div>";
	$right_float .= "<div class='clear'>&nbsp;</div>";

	return $right_float;
}
add_shortcode('right', 'ufandshands_shortcode_float_right');

// show content only on mobile
function ufandshands_shortcode_mobile_only($atts, $content = null) {
	extract(shortcode_atts(array(
                'autop' => '1',
		'fullonly' => '',
	), $atts));
	$content = do_shortcode($content);

	if($fullonly == 'yes'){
		$mobile_only = "<div class='shortcode_fullonly'>";
    }else{ 
		$mobile_only = "<div class='shortcode_mobileonly'>";
	}
	if ($autop=='1')
            $mobile_only .= wpautop($content);
        else
            $mobile_only .= $content;
            
	$mobile_only .= "</div>";
	$mobile_only .= "<div class='clear'>&nbsp;</div>";

	return $mobile_only;
}
add_shortcode('mobile', 'ufandshands_shortcode_mobile_only');





// google maps shortcode, courtesy of: http://blue-anvil.com/archives/8-fun-useful-shortcode-functions-for-wordpress/ 
// and courtesy of http://www.developer.com/tech/article.php/3615681/Introducing-Googles-Geocoding-Service.htm
// example usage: [googlemap zoom="13" center="52.66389056542801, 0.1641082763671875" marker="52.66389056542801, 0.1641082763671875" width="488px"]

function ufandshands_googlemap_shortcode( $atts ) {
    extract(shortcode_atts(array(
        'width' => '100%',
        'height' => '400px',
        'apikey' => 'ABQIAAAAsogIjHA_njjPITMFqPzMOBQThvvydD0IksfzMJ0uPnMKim3ZexTm8dJK8_y3Xc3ljRG_OOqTn-hOJQ',
	'address' => '',
        'zoom' => '13'
    ), $atts));
 
    $rand = rand(1,100) * rand(1,100);
 
    return '
    	<script src="http://maps.google.com/maps?file=api&v=2&sensor=false&key='.$apikey.'" type="text/javascript"></script>
 	<div id="map_canvas_'.$rand.'" style="width: '.$width.'; height: '.$height.'"></div>
	    <script type="text/javascript">

   		var address = "'.$address.'";

		// Create new map object
		var map = new GMap2(document.getElementById("map_canvas_'.$rand.'"));

		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());

                // Create new geocoding object
               var geocoder = new GClientGeocoder();

               // Retrieve location information, pass it to addToMap()
               geocoder.getLocations(address, addToMap);

               function addToMap(response)
               {
              	 // Retrieve the object
              	 place = response.Placemark[0];

               	// Retrieve the latitude and longitude
               	point = new GLatLng(place.Point.coordinates[1],
                                         place.Point.coordinates[0]);

               	// Center the map on this point
               	map.setCenter(point, 13);

               	// Create a marker
               	marker = new GMarker(point);

               	// Add the marker to map
               	map.addOverlay(marker);

               	// Add address information to marker
              	marker.openInfoWindowHtml(place.address);
		}

	</script>
    ';
}
add_shortcode('googlemap', 'ufandshands_googlemap_shortcode');



// google graphs shortcode, courtesy of: http://blue-anvil.com/archives/8-fun-useful-shortcode-functions-for-wordpress/
// example usage: [chart data="41.52,37.79,20.67,0.03" bg="F7F9FA" labels="Reffering+sites|Search+Engines|Direct+traffic|Other" colors="058DC7,50B432,ED561B,EDEF00" size="488x200" title="Traffic Sources" type="pie"]

function ufandshands_chart_shortcode( $atts ) {
	extract(shortcode_atts(array(
	    'data' => '',
	    'colors' => '',
	    'size' => '650x250',
	    'bg' => 'ffffff',
	    'title' => '',
	    'labels' => '',
	    'advanced' => '',
	    'type' => 'pie'
	), $atts));
 
	switch ($type) {
		case 'line' :
			$charttype = 'lc'; break;
		case 'xyline' :
			$charttype = 'lxy'; break;
		case 'sparkline' :
			$charttype = 'ls'; break;
		case 'meter' :
			$charttype = 'gom'; break;
		case 'scatter' :
			$charttype = 's'; break;
		case 'venn' :
			$charttype = 'v'; break;
		case 'pie' :
			$charttype = 'p3'; break;
		case 'pie2d' :
			$charttype = 'p'; break;
		default :
			$charttype = $type;
		break;
	}
 
	if ($title) $string .= '&chtt='.$title.'';
	if ($labels) $string .= '&chl='.$labels.'';
	if ($colors) $string .= '&chco='.$colors.'';
	$string .= '&chs='.$size.'';
	$string .= '&chd=t:'.$data.'';
	$string .= '&chf=bg,s,'.$bg.'';
 
	return '<img title="'.$title.'" src="http://chart.apis.google.com/chart?cht='.$charttype.''.$string.$advanced.'" alt="'.$title.'" />';
}
add_shortcode('chart', 'ufandshands_chart_shortcode');



// insert RSS feed using shortcode
function ufandshands_readRss($atts) {
	extract(shortcode_atts(array(
		"feed" => 'http://',
		"num" => '1',
		"summary" => 'false',
		"date" => 'false'
	), $atts));


	// Get RSS Feed(s)
	include_once(ABSPATH . WPINC . '/feed.php');

	// Get a SimplePie feed object from the specified feed source.
	$rss = fetch_feed($feed);

	if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
		// Figure out how many total items there are, but limit it to num. 
		$maxitems = $rss->get_item_quantity($num); 

		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items(0, $maxitems); 
	endif;

	$rss_widget_output = "<ul>";

	if ($maxitems == 0) {
		$rss_widget_output .= '<li>No items.</li>'; }
	else {
		// Loop through each feed item and display each item as a hyperlink.
		foreach ( $rss_items as $item ) : 
		$rss_widget_output .= "<li><a href=\"".$item->get_permalink()."\" title=\"Posted: ".$item->get_date('j F Y | g:i a')."\" >";
		$rss_widget_output .= $item->get_title();
		$rss_widget_output .="</a>";
		if( $date=='true' ){
			$rss_widget_output .= "<br /><span class='rss-date'>".$item->get_date('F j, Y')."</span>";
		}
		if($summary=="true") {
			$rss_widget_output .= "<p>".$item->get_description()."</p>";
		}
		
		$rss_widget_output .= "</li>";
		endforeach; 
	}
	
	$rss_widget_output .= "</ul>";

	return $rss_widget_output;
}
add_shortcode('rss', 'ufandshands_readRss');


// embed swf shortcode

function ufandshands_shortcode_swf($atts, $content = null) {
    extract(shortcode_atts(array(
	"width" => '100%',
	"height" => '400',
    ), $atts));

	$embed_code = "<object type=\"application/x-shockwave-flash\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0\" data=\"".$content."\" width=\"".$width."\" height=\"".$height."\" style=\"background-color:red;\">
<param name=\"movie\" value=\"".$content."\" />
<param name=\"quality\" value=\"high\"/>
</object>";

	return $embed_code;
}

add_shortcode('swf', 'ufandshands_shortcode_swf');


// insert HTML sitemap (http://wordpress.org/extend/plugins/html-sitemap/)
// adds an HTML (Not XML) sitemap of your blog pages (not posts) by entering the shortcode [html-sitemap].
// example: [html-sitemap depth=4 exclude=24]

function ufandshands_html_sitemap_shortcode_handler( $args, $content = null )
{
	if( is_feed() )
		return '';
		
	$args['echo'] = 0;
	$args['title_li'] = '';
	unset($args['link_before']);
	unset($args['link_after']);
	if( isset($args['child_of']) && $args['child_of'] == 'CURRENT' )
		$args['child_of'] = get_the_ID();
	else if( isset($args['child_of']) && $args['child_of'] == 'PARENT' )
	{
		$post = &get_post( get_the_ID() );
		if( $post->post_parent )
			$args['child_of'] = $post->post_parent;
		else
			unset( $args['child_of'] );
	}
	
	$html = wp_list_pages($args);

	// Remove the classes added by WordPress
	$html = preg_replace('/( class="[^"]+")/is', '', $html);
	return '<ul>'. $html .'</ul>';
}
add_shortcode('html-sitemap', 'ufandshands_html_sitemap_shortcode_handler');


// insert a tag cloud using a short code
function ufandshands_tagcloud_shortcode($atts) {
	if ($atts['format'] != 'columns') {  // render the tag cloud normally
	    extract(shortcode_atts(array(
		"taxonomy" => 'post_tag',
		"num" => '45',
		"format" => 'flat',
		"smallest" => '8',
		"largest" => '22',
		"orderby" => 'name',
		"order" => 'ASC',
		), $atts));

	    $order = strtoupper($order);
	    
	    //ob_start();
	    $tag_cloud = wp_tag_cloud(apply_filters('shortcode_widget_tag_cloud_args', array('taxonomy' => post_tag, 'echo' => false, 'number' => $num, 'format' => $format, 'smallest' => $smallest, 'largest' => $largest, 'orderby' => $orderby, 'order' => $order, "taxonomy" => $taxonomy) ));
	    //$tag_cloud = ob_get_contents();
	    //ob_end_clean();
	
	    return $tag_cloud;
	}
	else { // render the tag in multi-column format
	    return wp_mcTagMap_renderTags($atts);
	}
}
add_shortcode('tagcloud', 'ufandshands_tagcloud_shortcode');



// ** functions for rendering multi-column tag clouds **
function wp_mcTagMap_renderTags($options) {

    extract(shortcode_atts(array(
		"columns" => "4",
		"taxonomy" => 'post_tag',
		"show_empty" => "no",
		    ), $options));

    if ($show_empty == "yes") {
	$show_empty = "0";
    }
    if ($show_empty == "no") {
	$show_empty = "1";
    }


    
    $list = '<!-- begin list --><div id="mcTagMap">';
    $tags = get_terms($taxonomy, 'order=ASC&hide_empty=' . $show_empty . ''); // new code!
    $groups = array();


    if ($tags && is_array($tags)) {
	foreach ($tags as $tag) {
	    $first_letter = strtoupper($tag->name[0]);
	    $groups[$first_letter][] = $tag;
	}
	if (!empty($groups)) {
	    $count = 0;
	    $howmany = count($groups);

	    // this makes 2 columns
	    if ($columns == 2) {
		$firstrow = ceil($howmany * 0.5);
		$secondrow = ceil($howmany * 1);
		$firstrown1 = ceil(($howmany * 0.5) - 1);
		$secondrown1 = ceil(($howmany * 1) - 0);
	    }


	    //this makes 3 columns
	    if ($columns == 3) {
		$firstrow = ceil($howmany * 0.33);
		$secondrow = ceil($howmany * 0.66);
		$firstrown1 = ceil(($howmany * 0.33) - 1);
		$secondrown1 = ceil(($howmany * 0.66) - 1);
	    }

	    //this makes 4 columns
	    if ($columns == 4) {
		$firstrow = ceil($howmany * 0.25);
		$secondrow = ceil(($howmany * 0.5) + 1);
		$firstrown1 = ceil(($howmany * 0.25) - 1);
		$secondrown1 = ceil(($howmany * 0.5) - 0);
		$thirdrow = ceil(($howmany * 0.75) - 0);
		$thirdrow1 = ceil(($howmany * 0.75) - 1);
	    }

	    //this makes 5 columns
	    if ($columns == 5) {
		$firstrow = ceil($howmany * 0.2);
		$firstrown1 = ceil(($howmany * 0.2) - 1);
		$secondrow = ceil(($howmany * 0.4));
		$secondrown1 = ceil(($howmany * 0.4) - 1);
		$thirdrow = ceil(($howmany * 0.6) - 0);
		$thirdrow1 = ceil(($howmany * 0.6) - 1);
		$fourthrow = ceil(($howmany * 0.8) - 0);
		$fourthrow1 = ceil(($howmany * 0.8) - 1);
	    }

	    foreach ($groups as $letter => $tags) {
		if ($columns == 2) {
		    if ($count == 0 || $count == $firstrow || $count == $secondrow) {
			$list .= wp_mcTagMap_renderDivider($count, $firstrow);
		    }
		}
		if ($columns == 3) {
		    if ($count == 0 || $count == $firstrow || $count == $secondrow) {
			$list .= wp_mcTagMap_renderDivider($count, $secondrow);
		    }
		}
		if ($columns == 4) {
		    if ($count == 0 || $count == $firstrow || $count == $secondrow || $count == $thirdrow) {
			$list .= wp_mcTagMap_renderDivider($count, $thirdrow);
		    }
		}
		if ($columns == 5) {
		    if ($count == 0 || $count == $firstrow || $count == $secondrow || $count == $thirdrow || $count == $fourthrow){
			$list .= wp_mcTagMap_renderDivider($count, $fourthrow);
		    }
		}

		$list .= '<div class="tagindex">';
		$list .="\n";
		$list .='<h4>' . apply_filters('the_title', $letter) . '</h4>';
		$list .="\n";
		$list .= '<ul class="links">';
		$list .="\n";
		$i = 0;
		foreach ($tags as $tag) {
		    $url = get_term_link( intval($tag->term_id), $tag->taxonomy );
		    //$url = esc_attr(get_tag_link($tag->term_id));
		    $name = apply_filters('the_title', $tag->name);
		    //	$name = ucfirst($name);
		    $i++;
		    $counti = $i;
		    
		$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a></li>';
		    $list .="\n";
		}

		$list .= '</ul>';
		$list .="\n";
		$list .= '</div>';
		$list .="\n\n";
		if ($columns == 3 || $columns == 2) {
		    if ($count == $firstrown1 || $count == $secondrown1) {
			$list .= "</div>";
		    }
		}
		if ($columns == 4) {
		    if ($count == $firstrown1 || $count == $secondrown1 || $count == $thirdrow1) {
			$list .= "</div>";
		    }
		}
		if ($columns == 5) {
		    if ($count == $firstrown1 || $count == $secondrown1 || $count == $thirdrow1 || $count == $fourthrow1) {
			$list .= "</div>";
		    }
		}

		$count++;
	    }
	}
	$list .="</div>";
	$list .= "<div style='clear: both;'></div></div><!-- end list -->";
    }
    else
	$list .= '<p>Sorry, but no tags were found</p>';

    return $list;
}

function wp_mcTagMap_renderDivider($count, $rowNum) {
    $divider = "";
    if ($count == $rowNum) {
	$divider .= "\n<div class='holdleft noMargin'>\n";
	$divider .="\n";
    } else {
	$divider .= "\n<div class='holdleft'>\n";
	$divider .="\n";
    }
    
    return $divider;
}

// ** end functions for rendering multi-column tag clouds **


/*===============
* New Gallery Shortcode: will help us avoid having to hack at the core for the Gallery shortcode business
* courtesy of: http://coding.smashingmagazine.com/2011/05/26/better-image-management-practices-with-wordpress/
* ...with some slight modifications to the code to match current WP gallery output.
================*/
//Removing shands gallery shortcode, WP core 3.5 provides a built in, supported version
//remove_shortcode('gallery', 'gallery_shortcode');
//add_shortcode('gallery', 'ufandshands_gallery_shortcode');

function ufandshands_gallery_shortcode($attr) {
	global $post, $wp_locale;

	static $instance = 0;
	$instance++;

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We�re trusting author input, so let�s at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	//$default_exclude = get_post_thumbnail_id($post->ID);
	$exclude .= ","; 

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if ( apply_filters( 'use_default_gallery_style', true ) )
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->";
	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
	
	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, false, false); // changed the first booleans in the wp_get_attachment_link function to 'false'. This forces the gallery to link directly to the full image, and not the 'attachment page'. This avoids an old hack to the wordpress core.

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon'>
				$link
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both;" />';
	}

	$output .= "
			<br style='clear: both;' />
		</div>\n";

	return $output;
}

// Blogroll links shortcode for listing links by category (letter)
function ufl_links( $atts ) {
	extract( shortcode_atts( array(
		'cat' => 'all',
	), $atts ) );
	$link_list = '<ul class="link_list">';
	if ( $cat == 'all' ) {
		$link_list .= wp_list_bookmarks("categorize=1&title_li=&echo=0");
	} else {
		$link_list .= wp_list_bookmarks("categorize=0&title_li=&category={$cat}&echo=0");
	}
	$link_list .= '</ul>';
	return $link_list;
}
add_shortcode( 'ufl_links', 'ufl_links' );


// Generate link for referrer to Lift
function ufl_referrer_lift_link($atts, $content = null) {
	extract(shortcode_atts(array(
		'foo' => 'something',
		'bar' => 'something else',
	), $atts));
	
	$page_name = $_SERVER['HTTP_REFERER'];
	
	// get title of referring page
	$doc = new DOMDocument();
	$loaded = @ $doc->loadHTMLFile($page_name);
	$text = $doc->saveHTML();
	
	if ($loaded) {
		if (preg_match('/<title>(.*?)<\/title>/is',$text,$found)) {
			$title = $found[1];
		} else {
			$title = 'University of Florida';
		}
		$lift_link = '<a title="Your previous page via Lift Transcoder" href="http://assistive.usablenet.com/tt/'.$page_name.'">Browse "'.$title.'" with Lift</a>.';
	} else {
		$lift_link = 'There was an error determining the referring page. <a href="http://assistive.usablenet.com/tt/http://www.ufl.edu/">Please browse the UF web presence with Lift</a>.';
	}
	
	

	return wpautop($lift_link);
}
add_shortcode('ufl-lift-link', 'ufl_referrer_lift_link');


// Pull weather content in from assets.webadmin.ufl.edu
function ufl_weather_include($atts, $content = null) {
	extract(shortcode_atts(array(
		'feed' => 'http://assets.webadmin.ufl.edu/weather/current.html',
	), $atts));
	
	$doc = new DOMDocument();
	$loaded = @ $doc->loadHTMLFile($feed);
	$text = $doc->saveHTML();
	
	if ($loaded) {
		return $text;
	} else {
		return 'Weather information could not be loaded at this time.';
	}
}
add_shortcode('ufl-weather-include', 'ufl_weather_include');


// Get the latest news item from the weather feed at news.ufl.edu
// Can be used to pull any feed.
function ufl_news_rss_include($atts, $content = null) {
	extract(shortcode_atts(array(
		'feed' => 'http://news.ufl.edu/tags/weather/feed/',
		'items' => '1',
		'showfeedtitle' => false,
		'showdate' => false,
		'dateformat' => 'l, F jS, Y'
	), $atts));
	
	$rss = @ simplexml_load_file($feed);
	$feed_title = ($rss->channel->link == 'http://news.ufl.edu' ? '[UF News]' : '');
	
	if ($rss) {
		$output = '<ul>';
		foreach ($rss->channel->item as $feedItem) {
			$i++;
			$output .= '<li><a href="'.$feedItem->link.'">'.$feedItem->title.'</a>';
			if ($showfeedtitle == true) { $output .= ' '.$feed_title; }
			if ($showdate) { $output .= ' '.date( $dateformat, strtotime($feedItem->pubDate) ); }
			$output .= '</li>';
			if($i >= $items) break;
		}
		$output .= '</ul>';
		return $output;
	} else {
		return 'RSS updates from the <a href="'.$feed.'">specified feed</a> could not be loaded at this time.';
	}
	
	
	
}
add_shortcode('ufl-news-rss', 'ufl_news_rss_include');

// Display posts via shortcode
// From: http://www.billerickson.net/shortcode-to-display-posts/
add_shortcode('display-posts', 'be_display_posts_shortcode');
function be_display_posts_shortcode($atts) {

	// Pull in shortcode attributes and set defaults
	extract( shortcode_atts( array(
		'post_type' => 'post',
		'post_parent' => false,
		'id' => false,
		'tag' => '',
		'category' => '',
		'posts_per_page' => '10',
		'order' => 'DESC',
		'orderby' => 'date',
		'include_date' => false,
		'dateformat' => 'l, F jS, Y',
		'include_excerpt' => false,
		'image_size' => false,
		'wrapper' => 'ul',
		'taxonomy' => false,
		'tax_term' => false,
		'tax_operator' => 'IN'
	), $atts ) );
	
	// Set up initial query for post
	$args = array(
		'post_type' => explode( ',', $post_type ),
		'tag' => $tag,
		'category_name' => $category,
		'posts_per_page' => $posts_per_page,
		'order' => $order,
		'orderby' => $orderby,
	);
	
	// If Post IDs
	if( $id ) {
		$posts_in = explode( ',', $id );
		$args['post__in'] = $posts_in;
	}
	
	
	// If taxonomy attributes, create a taxonomy query
	if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {
	
		// Term string to array
		$tax_term = explode( ', ', $tax_term );
		
		// Validate operator
		if( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) )
			$tax_operator = 'IN';
					
		$tax_args = array(
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $tax_term,
					'operator' => $tax_operator
				)
			)
		);
		$args = array_merge( $args, $tax_args );
	}
	
	// If post parent attribute, set up parent
	if( $post_parent ) {
		if( 'current' == $post_parent ) {
			global $post;
			$post_parent = $post->ID;
		}
		$args['post_parent'] = $post_parent;
	}
	
	// Set up html elements used to wrap the posts. 
	// Default is ul/li, but can also be ol/li and div/div
	$wrapper_options = array( 'ul', 'ol', 'div' );
	if( !in_array( $wrapper, $wrapper_options ) )
		$wrapper = 'ul';
	if( 'div' == $wrapper )
		$inner_wrapper = 'div';
	else
		$inner_wrapper = 'li';

	
	$listing = new WP_Query( apply_filters( 'display_posts_shortcode_args', $args, $atts ) );
	if ( !$listing->have_posts() )
		return apply_filters ('display_posts_shortcode_no_results', false );
		
	$inner = '';
	while ( $listing->have_posts() ): $listing->the_post(); global $post;
		
		if ( $image_size && has_post_thumbnail() )  $image = '<a class="image" href="'. get_permalink() .'">'. get_the_post_thumbnail($post->ID, $image_size).'</a> ';
		else $image = '';
			
		$title = '<a class="title" href="'. get_permalink() .'">'. get_the_title() .'</a>';
		
		if ($include_date) $date = ' <span class="date">('. get_the_date($dateformat) .')</span>';
		else $date = '';
		
		if ($include_excerpt) $excerpt = ' - <span class="excerpt">' . get_the_excerpt() . '</span>';
		else $excerpt = '';
		
		$output = '<' . $inner_wrapper . ' class="listing-item">' . $image . $title . $date . $excerpt . '</' . $inner_wrapper . '>';
		
		$inner .= apply_filters( 'display_posts_shortcode_output', $output, $atts, $image, $title, $date, $excerpt, $inner_wrapper );
		
	endwhile; wp_reset_query();
	
	$open = apply_filters( 'display_posts_shortcode_wrapper_open', '<' . $wrapper . ' class="display-posts-listing">' );
	$close = apply_filters( 'display_posts_shortcode_wrapper_close', '</' . $wrapper . '>' );
	$return = $open . $inner . $close;

	return $return;
}
?>
