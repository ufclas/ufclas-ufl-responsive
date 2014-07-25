<?php

  $featured_category_id = of_get_option("opt_featured_category");
  $featured_cat_obj = get_category($featured_category_id);
  $featured_cat = $featured_cat_obj->cat_name;
  $featured_cat_number_of_posts = $featured_cat_obj->count;
  $slider_number_of_posts = of_get_option("opt_number_of_posts_to_show");
  $slider_speed = of_get_option("opt_featured_speed");
  $slider_disable_link = of_get_option("opt_featured_disable_link");
  ?>
<script type="text/javascript" charset="utf-8">
    $(window).load(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                pauseOnAction: true,    
                controlNav: true,
                directionNav: true, 
                controlsContainer: ".flexslider",
                prevText: "",
                nextText: "",
                slideshowSpeed: <?php echo (empty($slider_speed) ? 7000 : esc_html($slider_speed)); ?>,
                animationSpeed:1400
            })
});
  </script>
<div id="feature-wrap">
<?php if (!isset($_COOKIE["UFLmobileMobile"])){
    echo "<style>.flex-container{margin-top:0}.flexslider{border:none}</style>";
echo "<div id='slideshow-wrap'>";
}?> 
<div class="flex-container">
 <div class="flexslider">
    <ul class="slides">

 <?php
    query_posts(array('category_name' =>  $featured_cat, 'posts_per_page' =>  $slider_number_of_posts ));
    if(have_posts()) :
        while(have_posts()) : the_post();
            $custom_meta = get_post_custom($post->ID);
            $disabled_caption = $custom_meta['custom_meta_featured_content_disable_captions'];
			$image_type = $custom_meta['custom_meta_image_type'];
 ?>
<?php if(isset($image_type)): ?>
	<!-- Full-Size Image Output -->
	<li class="flex-full-width">
       
                  <?php if(!$slider_disable_link): ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php endif; ?>
          <?php the_post_thumbnail(); ?>
		  <?php if(!isset($disabled_caption)) : ?>
            <div class="flex-caption excerpt">
              	<h3><?php the_title();?></h3>
                <?php the_excerpt(); ?>
            	<span class="featured-arrow ir" width="40" height="40" alt="" />Featured arrow </span>
			</div>
            <?php endif; ?>
       <?php if(!$slider_disable_link): ?> </a><?php endif; ?>
      </li>
<?php else: ?>
	<!-- Half-Size Image Output -->
	<li class="flex-half-width" style="overflow:hidden">
		<?php if(isset($_COOKIE["UFLmobileFull"])): ?>
			<style>
			.excerpt{background:transparent !important;}
			</style>
		<?php endif; ?>
        <a href=" <?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> 
         <div class="half-size-container" style="width:50%; margin:0 auto;"><?php the_post_thumbnail(); ?></div>
		  <?php if(!isset($disabled_caption)) : ?>
			  <div class="flex-caption excerpt">
              	  <h3 class="half-size-title"><?php the_title();?></h3>
              	  <div class="half-size-excerpt"><?php the_excerpt(); ?>
            	  <span class="featured-arrow ir" width="40" height="40" alt="" />Featured arrow </span>
			   </div>
			</div>
            <?php endif; ?>
       <?php if(!$slider_disable_link): ?> </a><?php endif; ?>
      </li>

<?php endif; ?>    
<?php endwhile; endif; wp_reset_query();?>

    </ul>
  </div>
</div>
</div>
<?php if (!isset($_COOKIE["UFLmobileMobile"])){
echo "</div>";
}?>
