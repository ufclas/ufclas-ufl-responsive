<?php 
$opt_footer_widgets_visibility = of_get_option("opt_footer_widgets_visibility"); ?>
<footer role="contentinfo">
	<?php if ( ( $opt_footer_widgets_visibility === 'all_pages' ) || ( $opt_footer_widgets_visibility === 'homepage_only' && is_front_page() ) || ( $opt_footer_widgets_visibility === 'subpages_only' && !is_front_page() ) ) : ?>
		<?php if ( is_active_sidebar('site_footer') ): ?>
			<div class="container append-bottom">
			
				<div id="footer_top" class="footer_count_<?php ufandshands_sidebar_detector('site_footer',false,true) ?>">
					<?php dynamic_sidebar( 'site_footer' ); ?>
	        		<div class="clear"></div>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	
    <?php if (!$disabled_global_elements): ?>
	<div id="institutional-footer">
	  <div class="container"><span class="uf-monogram"></span>

		<div id="footer-links" class="span-24 black-25">
			
    	<?php if ( !$detect_mobile ): ?>
			<div class="footer_logo">
				<a href="http://www.ufl.edu/"><img src="<?php bloginfo('template_url'); ?>/images/uf_logo_full.png" alt="University of Florida" /></a>
			</div>
		<?php endif; ?>
		  
			<ul>
				<li><a href="https://webmail.ufl.edu/">WebMail</a></li>
				<li><a href="https://lss.at.ufl.edu/">e-Learning</a></li>
				<li><a href="https://one.uf.edu/">ONE.UF</a></li>
				<li><a href="https://my.ufl.edu/ps/signon.html">MyUFL</a></li>
				<li><a href="http://campusmap.ufl.edu/">Campus Map</a></li>
				<li><a href="http://news.ufl.edu/">News</a></li>
				<li><a href="http://calendar.ufl.edu/">Calendar</a></li>
				<li><a href="https://phonebook.ufl.edu/">Directory</a></li>
				<li><a href="http://www.ufl.edu/websites/">Web Site Listing</a></li>
				<li><a href="http://www.questions.ufl.edu/">Ask UF</a></li>
			</ul>
			<ul>
				<li><a href="http://assistive.usablenet.com/tt/<?php if ( empty($post->ID) ) { echo esc_url(home_url()); } else { echo esc_url(get_permalink( $post->ID )); } ?>" accesskey="t" title="Text-only version of this website">Text-only Version</a></li>
				<li><a href="http://www.ufl.edu/disability/">Disability Services</a></li>
				<li><a href="http://privacy.ufl.edu/privacystatement.html">Privacy Policy</a></li>
				<li><a href="http://regulations.ufl.edu/">Regulations</a></li>
				<?php $intranet_url = of_get_option("opt_intranet_url"); if(!empty($intranet_url)) { echo "<li><strong><a href=\"".$intranet_url."\">Intranet</a></strong></li> ";} ?>
				<?php $webmaster_email = of_get_option("opt_webmaster_email"); 
				if( !empty($webmaster_email) && ufl_check_email_address($webmaster_email) ) { 
					echo "<li><a id=\"contact-webmaster\" href=\"mailto:".$webmaster_email."\">Contact Webmaster</a></li> ";
				} elseif ( !empty($webmaster_email) ) {
					echo "<li><a id=\"contact-webmaster\" href=\"".$webmaster_email."\">Contact Webmaster</a></li> ";
				} ?>
				<li><?php //Make a gift fund URL
					$makeagift_url = of_get_option("opt_makeagift_url");
					if (!empty($makeagift_url)) {
						echo "<a href='".$makeagift_url."'>";
					} else { 
						echo "<a href='https://www.uff.ufl.edu/OnlineGiving/Advanced.asp'>";
					}
				?>Make a Gift</a></li>
			</ul>
			<ul>
				<li>&copy; <?php echo date('Y'); ?> <a href="http://www.ufl.edu/">University of Florida</a>, Gainesville, FL 32611; (352) 392-3261</li>
				<?php
					if ( is_home() ) {
						?> <li>Site Updated <?php ufl_site_last_updated(); ?></li> <?php
					} else {
						?> <li>Page Updated <?php the_modified_time('F j, Y'); ?></li> <?php
					}
				?>
			</ul>

			<p>This page uses <a href="http://www.google.com/analytics/">Google Analytics</a> (<a href="http://www.google.com/intl/en_ALL/privacypolicy.html">Google Privacy Policy</a>)</p>
			
		  </div><!-- end #footer-links -->
		</div><!-- end footer container -->
	</div><!-- end institutional footer container -->
    <?php else:  ?>
        <!-- Global footer disabled -->
		<?php if( is_active_sidebar('site_footer_custom') ): ?>
			<div id="footer-custom" class="container append-bottom">
				<div id="footer_top" class="footer_count_<?php ufandshands_sidebar_detector('site_footer_custom', true, true) ?>">
					<?php ufandshands_sidebar_detector('site_footer_custom'); ?>
	        		<div class="clear"></div>
				</div>
			</div><!-- end #footer-custom -->
        <?php endif; ?>
    <?php endif; ?>
</footer>
	
<?php 
//Custom JS
$custom_js = of_get_option('opt_custom_js');
if(!empty($custom_js)) {
	echo '<script type="text/javascript">' . $custom_js . '</script>'."\n";
}
?>
<!--[if lt IE 7 ]>
<script src="<?php bloginfo('template_url'); ?>/library/js/dd_belatedpng.js"></script>
<script> DD_belatedPNG.fix('img, .png_bg'); </script>
<![endif]-->
<?php wp_footer(); ?>
<?php include 'library/php/responsive-selector.php'; ?>
</body>
</html>
