<?php include("header.php"); ?>
	
	<div id="content" class="visuallyhidden"></div> <!-- on homepage for accessibility -->
	
	<?php // Set Featured Content vars
	  
		$featured_content_category = of_get_option("opt_featured_category");
		$story_stacker = of_get_option("opt_story_stacker");
	    
		if( !empty($featured_content_category) && !($featured_content_category=="Choose a Category") ) {  
      		
			//Checks if any posts are assigned to the chosen Featured Content Category in Theme Options
			$cat_posts = get_categories("include=" . $featured_content_category);
			$cat_count = ( !empty($cat_posts) )? $cat_posts[0]->category_count:0; 
			if($cat_count > 0) {
	?>
		<div id="feature-wrap" class="<?php if ($story_stacker) {echo "stacker";} ?>">
			<div id="feature" class="container" role="main">
		  
		  <!-- Story Stacker / Slider -->
				<?php

                if ( of_get_option('opt_responsive') ) {
                    if ( $detect_mobile ){
                        if ( !isset($_COOKIE["UFLmobileFull"]) ){
                            include('library/php/feature-responsive-slider.php');
                        } else if ( isset($_COOKIE["UFLmobileFull"]) ) {
                            if ( $story_stacker ) {
                                include('library/php/story-stacker.php');
                            } else {
                                include('library/php/feature-slider.php');
                            }
                        }
                    }else{
                        if ( $story_stacker ) {
                            include('library/php/story-stacker.php');
                        } else {
                            include('library/php/feature-slider.php');
                        }
                    }
                } else {
                    if ( $story_stacker ) {
                        include('library/php/story-stacker.php');
                    } else {
                        include('library/php/feature-slider.php');
                    }
                }

				?>
		  <!-- end Story Stacker / Slider -->
		  
			</div><!-- end #feature -->
		</div><!-- end #feature-wrap -->
	<?php } // endif for whether category has any posts
		} // endif for whether or not this is the 'choose a category' cat ?>
	
	<?php include('user-role-menu.php'); ?>
  
	<?php ufandshands_secondary_widget_area(); ?>
		
	
<?php include("footer.php"); ?>
