<?php get_header(); ?>

<?php ufandshands_breadcrumbs(); ?>

<div id="content-wrap">
	<div id="content-shadow">
		<div id="content" class="container">
	
			<article id="main-content" class="span-24" role="main">
				<div class="box">
				
					<?php if (have_posts()) : ?>
					  
					<?php
						// Retrieve search count
						  $allsearch = &new WP_Query("s=$s&showposts=-1");
						  $key = wp_specialchars($s, 1);
						  $count = $allsearch->post_count;
						  wp_reset_query();
					?>
            
						<h1 class="title medium-blue">Search Results for <span class="light-blue">&ldquo;</span><strong class="dark-blue"><?php the_search_query(); ?></strong><span class="light-blue">&rdquo;</span></h1>
            <h4 class="black-75"><?php if($count == '1') { echo ' ' . $count . ' result was found'; } else { echo ' ' . $count . ' results were found'; } ?></h4>
            
						<?php while (have_posts()) : the_post(); ?>
						  
							<?php   // Set Loop variables
								$currenttemplate = get_post_meta($post->ID,'_wp_page_template',true); 
								$ip = $_SERVER['REMOTE_ADDR'];
								$members_only = ufandshands_members_only();
							?>
								
						    <div class="entry">
													
								<?php							
									if($currenttemplate == "membersonly.php") : 
										if ($members_only) :   
								?>
								
								  <!-- Members Only -->
      							<?php
                      if (function_exists("ufandshands_post_thumbnail")) {
                        ufandshands_post_thumbnail('thumbnail', 'alignleft', 130, 100);
                      }
                    ?>
      							<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
      							<p class="published"><span class="black-50">Published: <?php the_time('M jS, Y') ?></span></p>
      							<?php the_excerpt(); ?>
																			
										<?php else : ?>
						
										<!-- Non-Members -->
										  <p>This document can only be seen by users inside the UF/Shands network.</p>
									  
									  <?php endif; ?>
								
								<?php else : ?>
								
								<!-- Non Members-Only Templates -->	
   							<?php
                  if (function_exists("ufandshands_post_thumbnail")) {
                   ufandshands_post_thumbnail('thumbnail', 'alignleft', 130, 100);
                  }
                ?>

								<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>  
								<p class="published"><span class="black-50">Published: <?php the_time('M jS, Y') ?></span></p>
								<?php the_excerpt() ?>
								
								</div><!-- end .entry -->
									
							<?php endif; ?>
													
						<?php endwhile; ?>
						
          <?php
                if (function_exists("ufandshands_pagination")) {
                ufandshands_pagination($additional_loop->max_num_pages);
                } else { ?>
                  <div class="single-navigation clear">
            				<div class="nav-previous"><?php previous_posts_link('&larr; Newer Entries') ?></div>
            				<div class="nav-next"><?php next_posts_link('Older Entries &rarr;') ?></div>
            			</div> 
          <?php  }?>

					<?php else : ?>

						<h2>No results found. Try a different search?</h2>

					<?php endif; ?>
					
				</div> <!-- end box div -->
			</article><!-- end #main-content --> 
		</div>
	</div>
</div>
<?php include('user-role-menu.php'); ?>
<?php include("footer.php"); ?>