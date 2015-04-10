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