<?php
	// Check to see if menu is set in the back end, if not default to what HSC did.
	if ( has_nav_menu('main_menu') ){
		$my_pages = wp_nav_menu( array('theme_location' => 'main_menu', 'echo' => 0, 'container' => 'false', 'walker' => new ufl_nav_walker));		
	}
	if ( $my_pages == '' ) {
		// Everything else is off so build the HSC way  
		$my_pages = wp_list_pages(array(
            'walker'   => new ufandshands_page_walker,
            'echo'     => 0,
            'title_li' => '',
            'depth'    => 3
            ));
	}
  $parts = preg_split("/(<ul class='children'|<li|<\/ul>)/", $my_pages, null, PREG_SPLIT_DELIM_CAPTURE);

  $newmenu = "";
	$level = 0;
  $counter = 1;
	foreach ($parts as $part) {
	  
	  if ("<ul class='children'" == $part) {++$level;}
      
      if ("</ul>" == $part) {--$level;}

        if( "<ul class='children'" == $part && $level == 1 ) {

          $var1 = "<ul class='children'";
          $var2 = "<div class='sub'><ul class='children'";
            $part = str_replace($var1, $var2, $part);
        }

        if( "<ul class='children'" == $part && $level == 2 ) {

          $var1 = "<ul class='children'";
          $var2 = "<ul class='subchildren'";
            $part = str_replace($var1, $var2, $part);
        }


        if( "</ul>" == $part && $level == 0 ) {

          $var1 = "</ul>";
          $var2 = "</ul></div>";
            $part = str_replace($var1, $var2, $part);
        }

		$newmenu .= $part;
		
	   
	}
	echo $newmenu;

?>
