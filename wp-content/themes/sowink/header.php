<?php
// sowink.com
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<!--
**********************************************************************************************

Designed and Built by Jason Schuller - theSevenFive.com, sowink.com

CSS, XHTML and Design Files are all Copyright 2007-2010 Circa75 Media, LLC

Be inspired, but please don't steal...

**********************************************************************************************
-->

<head profile="http://gmpg.org/xfn/11">
	<!-- page titles -->
	<title><?php if ( is_home() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;<?php bloginfo('description'); ?><?php } ?><?php if ( is_search() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Search Results<?php } ?><?php if ( is_author() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Author Archives<?php } ?><?php if ( is_single() ) { ?><?php wp_title(''); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?><?php if ( is_page() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;<?php wp_title(''); ?><?php } ?><?php if ( is_category() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Archive&nbsp;|&nbsp;<?php single_cat_title(); ?><?php } ?><?php if ( is_month() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Archive&nbsp;|&nbsp;<?php the_time('F'); ?><?php } ?><?php if (function_exists('is_tag')) { if ( is_tag() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Tag Archive&nbsp;|&nbsp;<?php  single_tag_title("", true); } } ?></title>
	
	<!-- meta tags -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<meta name="description" content="<?php the_excerpt_rss(); ?>" />
	<?php endwhile; endif; elseif(is_home()) : ?>
	<meta name="description" content="SoWink aims to revolutionize your dating world by making it ridiculously easy for you to brush up on dating tips, etiquette, relationship advice and other related insights on how to become the best you that you can be — never again let the person of your dreams slip away!" />
	<?php endif; ?>
	
	<!-- import required theme styles -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css3.css" type="text/css" media="screen" />
	
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style-ie7.css" type="text/css" media="screen" />
	<![endif]-->
	
	<!--[if IE 8]>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style-ie8.css" type="text/css" media="screen" />
	<![endif]-->
	
	<!-- pingback url -->
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  	
  	<!-- custom favicon -->
  	<?php $favicon_link = get_option(THEME_PREFIX.'favicon'); if ( !$favicon_link ) $favicon_link = get_bloginfo('template_url') . '/images/favicon-blog.ico'; ?>
	<link rel="shortcut icon" href="<?php echo $favicon_link; ?>" type="image/x-icon" />
	
	<?php if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
	
	<?php wp_head(); ?>
	
	<!-- custom theme styles if there are any -->
	<?php include (TEMPLATEPATH . '/style-custom.php'); ?>
	
	<!-- enable gravity forms -->
	<?php if (get_option(THEME_PREFIX . "gravity_forms")) { ?>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.gravity.css" type="text/css" media="screen" />
	<?php } ?>
	
	<!-- enable google analytics -->
	<?php echo get_option(THEME_PREFIX . "analytics_code"); ?>
</head>

<body>
	<div id="head-container">
		<div id="header">
			<div id="logo">
			<?php if (get_option(THEME_PREFIX . "logo_txt")) : ?>
				<h1><a href="<?php echo get_option('home'); ?>/" title="Home" ><?php echo get_option(THEME_PREFIX . "logo_txt"); ?></a></h1>
			<?php else : ?>
				<a href="<?php echo get_option('home'); ?>/" title="Home" ><img class="logo" src="<?php echo ($logo = get_option(THEME_PREFIX . 'logo_img')) ? $logo : get_bloginfo("template_url") . "/images/logo.png"; ?>" alt="<?php bloginfo('name'); ?>" /></a>
			<?php endif; ?>
			</div> <!-- logo -->
			
			<div id="navigation">
				<?php if (get_option(THEME_PREFIX . "menu_management")) : ?>
				<?php wp_nav_menu(array('theme_location' => 'main_menu', 'container_class' => 'menu-header')); ?>
				<?php else : ?>
				<ul class="menu">
					<li <?php if (is_home()) { echo 'class="current"'; } ?>><a href="<?php echo get_option('home'); ?>/" title="Home">Home</a></li>
					
					<li><a href="#" title="Browse Content Categories">Categories</a>
						<ul>
							<?php wp_list_categories('title_li='); ?>
						</ul>
					</li>
					
					<?php wp_list_pages('title_li='); ?>
					
					<li class="subscribe"><a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe via RSS">Subscribe</a></li>
					
					<?php if (get_option(THEME_PREFIX . "twitter_link")) { ?>
					<li class="twitter"><a href="http://twitter.com/<?php echo get_option(THEME_PREFIX . "twitter_link"); ?>" title="Twitter.com">Twitter</a></li>
					<?php } ?>
				</ul>
				<?php endif; ?>
			</div> <!-- navigation -->
		</div> <!-- header -->
	</div><!-- head-container -->
	<div id="content">
		
