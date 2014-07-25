<?php if ( ufl_check_page_visitor_level( $post->ID ) > 0 ) { define( 'DONOTCACHEPAGE', 1 ); } ?>
<?php include("header.php"); ?>

	<?php ufandshands_breadcrumbs(); ?>
	
	<div id="content-wrap">
	  <div id="content-shadow">
		<div id="content" class="container">
		
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

		<?php if ( ufl_check_authorized_user( $post->ID ) ) { // check if logged in/valid shib user required ?>

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
			
		<?php } else { // users are not logged in display error or login button ?>

					<h2>Protected</h2>
				
					<p>This content can only be seen by authorized users. Please login by clicking the button below.</p>

					<?php 
					if ( ufl_check_page_visitor_level($post->ID) == '2' ) {
						ufl_shibboleth_login_button();
					} else {
						?><p><a href="<?php echo wp_login_url(); ?>" class="button" title="Login">WordPress Login</a></p><?php
					}
					?>
					
		<?php } ?>

				</article>
			
		<?php //page right sidebar
			if ($page_right_sidebar) {
				echo "<aside id='local-sidebar' class='span-6 omega'>";
				echo $page_right_sidebar;
				echo "</aside><!-- end #local-sidebar -->";
			}
		?>
		
		</div>
	  </div>
	</div>
<?php include('user-role-menu.php'); ?>
<?php include("footer.php"); ?>
