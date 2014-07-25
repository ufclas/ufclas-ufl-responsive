<?php
/*
Template Name: Members Only Page
*/
?>
<?php include("header.php"); ?>

	<?php ufandshands_breadcrumbs(); ?>
	
	<div id="content-wrap">
	  <div id="content-shadow">
		<div id="content" class="container">
		
		<?php $currenttemplate = get_post_meta($post->ID, '_wp_page_template', true); //members only template check ?>
				
		<?php if ( ($currenttemplate != "membersonly.php") || ( ($currenttemplate == "membersonly.php") && ufandshands_members_only() ) ) { //members only logic?>
		
			<?php get_sidebar(); //call in the sidebar and navigation ?>
      
      <?php
    
        $page_right_sidebar = ufandshands_sidebar_detector('page_right',false);
       
        $article_width = '';
     
		if(((!empty($ufandshands_sidebar_nav) || !empty($ufandshands_sidebar_widgets)) && $page_right_sidebar)) {
			$article_width = '12';
			$content_width = 460; 
		} elseif (((!empty($ufandshands_sidebar_nav) || !empty($ufandshands_sidebar_widgets)) && !$page_right_sidebar)) {
			$article_width = '18';
			$content_width = 680; 
		} elseif ((empty($ufandshands_sidebar_nav) && empty($ufandshands_sidebar_widgets) && $page_right_sidebar)) {
			$article_width = '17 box';
			$content_width = 660; 
		} else {
			$article_width = '23 box';
			$content_width = 900; 
		}
       
      ?>
      
			<article id="main-content" class="span-<?php echo $article_width; ?>" role="main">
        
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
				  <?php ufandshands_content_title(); //page title ?>
				  

						<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					
				<div class="single-meta">
				  <?php the_tags('<p class="tag black-50">Tagged as: ', ', ','</p>'); ?>
				</div>

				<?php endwhile; endif; //main article loop ends?>

				<?php if ( is_user_logged_in() ) { ?>
					<p id="edit" class="clear" style="margin-top:20px;"><?php edit_post_link('Edit this article', '&nbsp; &raquo; ', ''); ?> | <a href="<?php echo wp_logout_url(); ?>" title="Log out of this account">Log out &raquo;</a></p>
				<?php } ?> 
			
			</article><!-- end #main-content --> 
      
      <?php //page right sidebar
				if ($page_right_sidebar) {
					echo "<aside id='local-sidebar' class='span-6 omega'>";
					echo $page_right_sidebar;
					echo "</aside><!-- end #local-sidebar -->";
				}
			?>

			
		<?php } else { //end members only check ?>

				<!-- Non-Members -->
				<article name ="content" id="main-content" class="span-23 box" role="main">
					<p>This content can only be seen by users inside the UF/Shands network. Please use one of the following VPN services or <a href="/wp-admin">login as a user of this website</a></p>
					
					<ul>
						<li><a href="http://net-services.ufl.edu/provided_services/vpn/anyconnect/">UF VPN</a></li>
						<li><a href="https://security.health.ufl.edu/vpn/">UF HSC VPN</a></li>
						<li><a href="https://vpn.shands.org/">Shands HealthCare VPN</a></li>
					</ul>
				</article>
		
		<?php } ?>
	    </div>
	  </div>
	</div>
<?php include('user-role-menu.php'); ?>
<?php include("footer.php"); ?>