<?php
  
  
  $featured_category_id = of_get_option("opt_featured_category");
  $featured_cat_obj = get_category($featured_category_id);
  $featured_cat_number_of_posts = $featured_cat_obj->count;
  
  $slider_number_of_posts = of_get_option("opt_number_of_posts_to_show");
  $slider_speed = of_get_option("opt_featured_speed");
  $slider_disable_link = of_get_option("opt_featured_disable_link");
  
   // Whether a widget should appear in right side of featured area
  $ufclas_responsive_home_featured_widgets = of_get_option("opt_home_featured_widgets");
  
  // Checks if user has chosen a selection (theme options) that exceeds number of available posts
  // in the featured category -- if so, falls back valid number.
   
  if($slider_number_of_posts > $featured_cat_number_of_posts) {
    $slider_number_of_posts = $featured_cat_number_of_posts;
  }
  
  $slider_feature_posts = new WP_Query();
  $slider_feature_posts->query("showposts=". $slider_number_of_posts . "&cat=" . $featured_category_id . "");
  $slider_feature_counter = 1;

  	// Adds home featured widget tags 
	if($ufclas_responsive_home_featured_widgets) { ?>
	<div id="featured-widgets">
	<div id="featured-widget-left">
	<?php } ?>
    
<script type="text/javascript">var sliderSpeed = <?php echo (empty($slider_speed) ? 7000 : esc_html($slider_speed)); ?></script> 
<div id="slideshow-wrap">
<div id="slideshow">
    <div id="slideshow-reel">
        <?php while ($slider_feature_posts->have_posts()) : $slider_feature_posts->the_post(); ?>
        <?php        
			$custom_meta = get_post_custom($post->ID);
			$image_type = ( isset($custom_meta['custom_meta_image_type']) )? $custom_meta['custom_meta_image_type']:null;
			$image_effect_disabled = ( isset($custom_meta['custom_meta_image_effect_disabled']) )? $custom_meta['custom_meta_image_effect_disabled']:null;
			$custom_button_text = ( isset($custom_meta['custom_meta_featured_content_button_text']) )? $custom_meta['custom_meta_featured_content_button_text'][0]:null; 
			$disabled_caption = ( isset($custom_meta['custom_meta_featured_content_disable_captions']) )? $custom_meta['custom_meta_featured_content_disable_captions']:null;
			$disable_timeline = of_get_option("opt_featured_content_disable_timeline");
        ?>
        
        <!-- Full-Size Image Output -->
        
        <?php if (isset($image_type)) : ?>
          <div class="slide <?php echo 'slide-' . $slider_feature_counter; ?> <?php echo 'post-' . $post->ID; ?> full-image-feature">
              <?php if ( has_post_thumbnail() ): ?>
                  <?php if(!$slider_disable_link): ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php endif; ?>
          			  <?php the_post_thumbnail('full-width-thumb'); ?>
                  <?php if(!$slider_disable_link): ?></a><?php endif; ?>
              <?php endif;?>
				<?php if(!isset($disabled_caption)) : ?>
				    <div class="excerpt">
					<?php if(!$slider_disable_link): ?><a href="<?php the_permalink(); ?>"><?php endif; ?>
					  <h3><?php the_title(); ?></h3>
					  <?php the_excerpt(); ?>
					  <?php if(!$slider_disable_link): ?><img src="<?php bloginfo('stylesheet_directory'); ?>/images/feature-arrow.png" class="featured-arrow" alt="" /><?php endif; ?>
					<?php if (!empty($custom_button_text)): ?>
					  <a class="read-more" href="<?php echo get_permalink(); ?>"><?php echo $custom_button_text; ?></a>
					<?php endif ?>
					<?php if(!$slider_disable_link): ?></a><?php endif; ?>
				    </div><!-- end .excerpt -->
				<?php endif ?>
          </div><!-- end .slide -->
          
        <!-- Half-Size Image Output -->
        
        <?php else : ?>
          <div class="slide <?php echo 'slide-' . $slider_feature_counter; ?> half-image-feature <?php if(isset($image_effect_disabled)) {echo 'half-image-style-disabled'; } ?> ">
              <?php if ( has_post_thumbnail() ) : ?>
                  <?php if(!$slider_disable_link): ?><a href="<?php the_permalink(); ?>"><?php endif; ?>
                  <?php the_post_thumbnail('half-width-thumb'); ?>
                  <?php if(!$slider_disable_link): ?></a><?php endif; ?>
				<?php endif ?>
				  <div class="excerpt">
					<h3><?php if(!$slider_disable_link): ?><a href="<?php the_permalink(); ?>"><?php endif; ?><?php the_title(); ?><?php if(!$slider_disable_link): ?></a><?php endif; ?></h3>
					<?php the_excerpt(); ?>
				  </div><!-- end .excerpt -->
          </div><!-- end .slide -->
        <?php endif; ?>
          
            <?php $slider_feature_counter++; ?>

        <?php endwhile; ?>
        
    </div><!-- end #slideshow-reel -->
    
    
    <?php if(!($slider_number_of_posts == 1)) : ?>
      <a href="#" id="slideshow-left" class="slideshow-arrow"></a>
      <a href="#" id="slideshow-right" class="slideshow-arrow"></a>
      
	  <?php if(!$disable_timeline): ?>
      <div id="slideshow-nav-wrap">
		  <div id="slideshow-nav">
			<?php $slider_feature_counter = 1; // Reset the counter ?>
			<?php while ($slider_feature_posts->have_posts()) : $slider_feature_posts->the_post(); ?>
			<a href="#" class="nav-item">
				<span class="nav-item-line <?php if($slider_feature_counter == 1) { echo "nav-item-line-hidden"; } ?>"></span>
				<span class="nav-item-dot"></span>
				<span class="nav-item-line <?php if($slider_feature_counter == $slider_number_of_posts) { echo "nav-item-line-hidden"; } ?>"></span>
        <div class="slider-thumb">
          <?php the_post_thumbnail('slider-scrubber-thumb'); ?>
        </div>
			</a>
			
			<?php $slider_feature_counter++; ?>
			
			<?php endwhile; ?>
			
			<span id="active-nav-item"></span>
			
		  </div><!-- end #slideshow-nav -->
      </div>
	  <?php endif; ?>
    <?php endif; ?>
    <?php if($slider_disable_link): ?>
    	<style>
    		#slideshow .full-image-feature .excerpt:hover {
			    cursor: default;
			}
    	</style>
	<?php endif; ?>

</div><!-- end #slideshow -->
</div><!-- end #slideshow-wrap -->
<?php 
	// Adds home featured widget area and sidebar 
	if($ufclas_responsive_home_featured_widgets) { ?>
</div><!-- end #featured-widget-left -->
	<?php ufclas_responsive_featured_widget_area(); ?>
</div><!-- end #featured-widgets -->
<?php } ?>