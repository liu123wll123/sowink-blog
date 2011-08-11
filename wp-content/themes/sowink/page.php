<?php get_header(); ?>

<div id="blog">
	<div id="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div id="post-<?php the_ID(); ?>" class="post-item">		
			<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			
			<div <?php post_class('') ?>>
				<a href="<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 1000,1000 ), false, '' ); echo $src[0]; ?>" class="fancy" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a>
				<?php the_content('... Continue Reading'); ?>
			</div>
		</div> <!-- post -->
		
		<?php endwhile; else : ?>
		
		<div id="nothing-here">			
			<h2>404! Oh no! Pandwink, where is the page?</h2>
			
			<div class="page">
				<p>Professor Pandwink recommends you try these: </p>
				<div class="categs">Were you looking for <a href="http://sowink.com" title="SoWink | Revolutionizing Your Dating World">sowink.com</a>?<div id="lost-panda"></div></div>
				<h4 class="not-here">Find Posts by Title:</h4>
				<ul>
				<?php query_posts('&showposts=1000&orderby=title&order=asc'); if (have_posts()) : while (have_posts()) : the_post(); ?>
					<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>									
				<?php endwhile; endif; ?> 
				</ul>
				
				<h4 class="not-here">Find Posts by Month:</h4>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
				
				<h4 class="not-here">Find Posts by Category:</h4>
				<ul>
					<?php wp_list_categories('title_li='); ?>
				</ul>
				
				<h4 class="not-here">Looking for a page?</h4>
				<ul class="not-here-pages">
					<?php wp_list_pages('title_li='); ?>
				</ul>
			</div> <!-- page -->
		</div> <!-- nothing-here -->
		
		<?php endif; ?>
	</div> <!-- main -->
	
	<?php get_sidebar(); ?>
</div> <!-- blog -->

<?php get_footer(); ?>