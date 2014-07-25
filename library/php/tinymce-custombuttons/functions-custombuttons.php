<?php

require_once('custombutton.php');
require_once('formfield.php');
require_once('buttons.php');

// TinyMCE: First line toolbar customizations
if( !function_exists('ufandshands_base_extended_editor_mce_buttons') ){
	function ufandshands_base_extended_editor_mce_buttons($buttons) {
		// The settings are returned in this array. Customize to suite your needs.
		return array(
			'bold', 'italic', 'strikethrough', 'separator', 
			'bullist', 'numlist', 'blockquote', 'separator', 
			'justifyleft', 'justifycenter', 'justifyright', 'separator', 
			'link', 'unlink', 'wp_more', 'separator', 
			'spellchecker', 'fullscreen', 'wp_adv'
		);
		/* WordPress Default
		return array(
			'bold', 'italic', 'strikethrough', 'separator', 
			'bullist', 'numlist', 'blockquote', 'separator', 
			'justifyleft', 'justifycenter', 'justifyright', 'separator', 
			'link', 'unlink', 'wp_more', 'separator', 
			'spellchecker', 'fullscreen', 'wp_adv'
		); */
	}
	add_filter("mce_buttons", "ufandshands_base_extended_editor_mce_buttons", 0);
}
 
// TinyMCE: Second line toolbar customizations
if( !function_exists('ufandshands_base_extended_editor_mce_buttons_2') ){
	function ufandshands_base_extended_editor_mce_buttons_2($buttons) {
		// The settings are returned in this array. Customize to suite your needs. An empty array is used here because I remove the second row of icons.
		return array(
      'formatselect', 'separator', 
			'pastetext', 'pasteword', 'removeformat', 'separator', 
			'charmap', 'separator', 
			'outdent', 'indent', 'separator', 
			'undo', 'redo', 'wp_help'
    );
    
		/* WordPress Default
		return array(
			'formatselect', 'underline', 'justifyfull', 'forecolor', 'separator', 
			'pastetext', 'pasteword', 'removeformat', 'separator', 
			'media', 'charmap', 'separator', 
			'outdent', 'indent', 'separator', 
			'undo', 'redo', 'wp_help'
		); */
	}
	add_filter("mce_buttons_2", "ufandshands_base_extended_editor_mce_buttons_2", 0);
}

// Customize the format dropdown items and allow empty line breaks
if( !function_exists('ufandshands_base_custom_mce_format') ){
	function ufandshands_base_custom_mce_format($init) {
    // Add block format elements you want to show in dropdown - h1 reserved by template - removed
		$init['theme_advanced_blockformats'] = 'p,h2,h3,h4,h5,h6,pre';
		return $init;
	}
	add_filter('tiny_mce_before_init', 'ufandshands_base_custom_mce_format' );
}




function add_custom_buttons() {
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
   if ( get_user_option('rich_editing') == 'true') {
     
     add_filter('mce_external_plugins', 'add_youtube_tinymce_plugin');
     add_filter('mce_buttons_3', 'register_custom_buttons');

   }
}
add_action('init', 'add_custom_buttons');

function register_custom_buttons($buttons) {
   $customButtons =  loadCustomButtons();
   for ($i = 0; $i < sizeof($customButtons); $i++) {
       array_push($buttons, $customButtons[$i]->buttonSeparator, $customButtons[$i]->shortCodeTag);
   }
   
   return $buttons;
}

function add_youtube_tinymce_plugin($plugin_array) {

   $plugin_array['shortcodebuttons'] = get_bloginfo('template_url').'/library/php/tinymce-custombuttons/tinymce-custombuttons.js.php';
 
   return $plugin_array;
}

function my_refresh_mce($ver) {
  $ver += 3;
  return $ver;
}

add_filter( 'tiny_mce_version', 'my_refresh_mce');

// Add Style Select Menu to TinyMCE's 2nd Row
function ufandshands_mce_buttons_2( $buttons ) {
    array_splice( $buttons, 1, 0, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'ufandshands_mce_buttons_2' );

//Customize the classes options inside the Style Select Menu
function ufandshands_mce_before_init( $settings ) {

    $style_formats = array(
        array(
        	'title' => 'Lead-in',
        	'block' => 'p',
        	'classes' => 'lead'
        )
//        array(
//          'title' => 'Orange',
//          'inline' => 'span',
//          'classes' => 'b-orange'
//        ),
//        array(
//          'title' => 'Medium Blue',
//          'inline' => 'span',
//          'classes' => 'medium-blue'
//        ),
//        array(
//          'title' => 'Dark Blue',
//          'inline' => 'span',
//          'classes' => 'dark-blue'
//        )
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}
add_filter( 'tiny_mce_before_init', 'ufandshands_mce_before_init' );

?>