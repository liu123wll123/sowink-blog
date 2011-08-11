<?php get_header(); ?>

<div id="blog">
	<div id="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div id="post-<?php the_ID(); ?>" class="post-item">
			<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<p class="post-meta">by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="View all posts by <?php the_author(); ?>"><?php the_author(); ?></a> on <?php the_time('F j, Y'); ?></p>
			<div <?php post_class('') ?>>
				<a href="<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 1000,1000 ), false, '' ); echo $src[0]; ?>" class="fancy" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a>
				<?php the_content('... Continue Reading'); ?>
                <div id="socials">
                    <div id="tw-root"><a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo post_permalink(	); ?>" data-text="<?php echo"SoWink Blog - "; echo get_the_title(); ?>" data-count="horizontal" data-via="sowink_inc">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
                    <div id="fb-root"><script src="http://connect.facebook.net/en_US/all.js#appId=177110085676927&amp;xfbml=1"></script><fb:like href="" send="false" layout="button_count" width="100" show_faces="false" font="trebuchet ms"></fb:like></div>
                </div>
			</div>
			<div class="categs">Posted in <?php foreach((get_the_category()) as $category) { echo '<a href="http://blog.sowink.com/category/' . $category->slug . '" title="View all posts in this category."> ' . $category->cat_name . ' </a>'; } 
?><div class="dates"><?php comments_number('0','1','%'); ?> comments</div><!-- #dates --></div><!-- #categs -->
		</div> <!-- post -->
		
		<?php comments_template(); ?>
		
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
