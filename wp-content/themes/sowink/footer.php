	</div> <!-- content -->
	<div id="footer">
			<div id="footer-content">
			<?php if (get_option(THEME_PREFIX . "copy_text")) { ?>
				<h3>&copy;<?php echo date("Y"); ?> <?php echo get_option(THEME_PREFIX . "copy_text"); ?> All rights reserved</h3>
			<?php } ?>
			
			<?php if (get_option(THEME_PREFIX . "footer_text")) : ?>
				<p><?php echo get_option(THEME_PREFIX . "footer_text"); ?></p>
			<?php else : ?>
			<?php endif; ?>
			<ul>
				<li><a href="http://blog.sowink.com/category/updates" title="Check SoWink status and updates.">Updates</a></li>
				<li><a href="http://feedburner.google.com/fb/a/mailverify?uri=SoWink&amp;loc=en_US" title="Keep the revolution strong—stay updated with the latest dating tips.">Subscribe</a></li>
				<li><a href="http://blog.sowink.com/about" title="Meet the SoWink team!">About</a></li>
				<li><a href="http://blog.sowink.com/jobs" title="Be a part of the next generation dating site!">Jobs</a></li>
				<li><a href="http://blog.sowink.com/contactus/" title="Contact the SoWink team.">Contact</a></li>
				
			</ul>
			</div>
						
			<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
		</div> <!-- footer -->
	<?php wp_footer(); ?>
	
	<?php if (get_option(THEME_PREFIX . "no_ie")) { ?>
	<!--[if IE 6]>
	<script type="text/javascript"> 
		/*Load jQuery if not already loaded*/ if(typeof jQuery == 'undefined'){ document.write("<script type=\"text/javascript\"   src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js\"></"+"script>"); var __noconflict = true; } 
		var IE6UPDATE_OPTIONS = {
			icons_path: "http://static.ie6update.com/hosted/ie6update/images/"
		}
	</script>
	<script type="text/javascript" src="http://static.ie6update.com/hosted/ie6update/ie6update.js"></script>
	<![endif]-->
	<?php } ?>
</body>
</html>