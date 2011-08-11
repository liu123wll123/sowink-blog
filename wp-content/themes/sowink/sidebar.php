<div id="sidebar">
	<?php if ( is_home() ) { ?>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Page') ) : ?>
	<?php endif; ?>
	<?php } ?>
	
	<?php if ( is_category() || is_search() || is_archive() ) { ?>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Multiple Post Pages') ) : ?>
	<?php endif; ?>
	<?php } ?>
	
	<?php if ( is_single() ) { ?>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Single Post Pages') ) : ?>
	<?php endif; ?>
	<?php } ?>
	
	<?php if ( is_page() ) { ?>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Pages') ) : ?>
	<?php endif; ?>
	<?php } ?>
</div> <!-- sidebar -->