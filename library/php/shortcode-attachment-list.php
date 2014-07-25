<?php

/*
 * Create shortcode to display a list of attachments by filetype
 */
function ufl_display_attached_items_list($atts, $content = null) {
	extract(shortcode_atts(array(
		'filetype' => 'pdf',
		'showdesc' => 'false',
		'order' => 'asc',
		'orderby' => 'name',
		'showasdates' => 'false',
		'dateformat' => 'F j, Y',
		'exclude' => '',
		'outputtype' => 'list',
		'limit' => '-1'
	), $atts));

	global $post;
	// List of mime types
	$mime_types = array(
		"pdf"=>"application/pdf","zip"=>"application/zip","docx"=>"application/vnd.openxmlformats-officedocument.wordprocessingml.document","doc"=>"application/msword","xls"=>"application/vnd.ms-excel","xlsx"=>"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","ppt"=>"application/vnd.ms-powerpoint","pptx"=>"application/vnd.openxmlformats-officedocument.presentationml.presentation","gif"=>"image/gif","png"=>"image/png","jpeg"=>"image/jpg","jpg"=>"image/jpg","mp3"=>"audio/mpeg","wav"=>"audio/x-wav","mpeg"=>"video/mpeg","mpg"=>"video/mpeg","mpe"=>"video/mpeg","mov"=>"video/quicktime","avi"=>"video/x-msvideo"
	);

	$args = array( 'orderby' => $orderby, 'order' => $order, 'post_type' => 'attachment', 'numberposts' => $limit, 'post_status' => null, 'post_parent' => $post->ID, 'exclude' => $exclude );
	if ( $filetype != "all" ) {
		$short_mime_types = explode(",", $filetype);
		foreach ($short_mime_types as $key => $short) {
			$types[] = $mime_types[$short];
		}
		$mimes = array( 'post_mime_type' => $types );
		$args = array_merge( $args, $mimes );
	}
	$attachments = get_posts($args);
	if ( $attachments ) {
		if ( $outputtype == 'list' ) {
			// Build UL to return if items were found.
			$out = '<ul class="attachment-list attachment-list-'.$filetype.'">';
			foreach ( $attachments as $attachment ) {
				if ( $showasdates == 'true' && is_numeric( substr( $attachment->post_title, -8 ) ) ) { $link_text = date( $dateformat, strtotime( substr( $attachment->post_title, -8 ) ) ); }
				$out .= '<li>' . wp_get_attachment_link( $attachment->ID , false, false, false, $link_text ) . ' <span>(' . strtoupper( array_search( get_post_mime_type( $attachment->ID ), $mime_types ) ) . ', ' . size_format( filesize( get_attached_file( $attachment->ID ) ) ) . ')</span>';
				if ($showdesc == 'true') { $out .= '<br><p>'.$attachment->post_content.'</p>'; }
				$out .= '</li>';
			}
			$out .= '</ul>';
		} elseif ( $outputtype == 'single' && $limit == '1' ) {
			foreach ( $attachments as $attachment ) {
				$out = wp_get_attachment_link( $attachment->ID , false, false, false, $link_text ) . ' <span>(' . strtoupper( array_search( get_post_mime_type( $attachment->ID ), $mime_types ) ) . ', ' . size_format( filesize( get_attached_file( $attachment->ID ) ) ) . ')</span>';
			}
		}
	} else {
		// Return blank string if there is nothing attached.
		$out = '';
	}
	return $out;
}
add_shortcode('attachment-list', 'ufl_display_attached_items_list');
?>
