<?php

// Theme Constants
define("THEME_PREFIX", "sideblog_");

// Theme Location
define('THEME', get_bloginfo('template_url'), true);

// WordPress Post Thumbnail Support
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(510, 220, true);
    add_image_size('sidebar', 75, 75, true);
}

// WordPress Custom Menu Support
add_action('init', 'register_custom_menu');
 
function register_custom_menu() {
register_nav_menu('main_menu', __('Main Menu'));
}

add_filter('widget_text', 'do_shortcode');

// Add RSS Feed Links
add_theme_support( 'automatic-feed-links' );

// Include Custom Theme Widgets
include("widgets/cat-posts.php");
include("widgets/simple-sidebar-ads.php");

// Load Required Theme Scripts
function sf_theme_js() {
	if (is_admin()) return;
	wp_enqueue_script('jquery');
	wp_enqueue_script('superfish', THEME . '/scripts/jquery.superfish.js');
	wp_enqueue_script('easing', THEME . '/scripts/jquery.easing.js', 'jquery');
	wp_enqueue_style('fancybox', THEME . '/scripts/fancybox/style.css');
	wp_enqueue_script('fancybox', THEME . '/scripts/fancybox/jquery.fancybox.js', 'jquery');
}
add_action('init', sf_theme_js);

// The Admin Page
add_action('admin_menu', "sf_sideblog_admin_init");

// Register Admin
function sf_sideblog_admin_init()
{
	$page = add_theme_page( "SoWink Options", "Theme Options", 8, 'sf_sideblog_admin_menu', 'sf_sideblog_admin');

	// Custom Image Uploaders
	sf_add_img_upload_filter(THEME_PREFIX.'background_img', 'sf_handle_bg_upload');
	sf_add_img_upload_filter(THEME_PREFIX.'logo_img', 'sf_handle_logo_upload');
	sf_add_img_upload_filter(THEME_PREFIX.'favicon', 'sf_handle_favicon_upload');
}

// Image Upload Helper Function
function sf_add_img_upload_filter($option_name, $handler) {
  add_filter('pre_update_option_'.$option_name, $handler, 10, 2);
}

// Image Upload Handler Functions
function sf_handle_bg_upload($new_value, $old_value) {
  return sf_handle_img_upload(
    $new_value, 
    $old_value, 
    THEME_PREFIX.'background_img_upload', 
    THEME_PREFIX.'delete_bg_img');
}

function sf_handle_logo_upload($new_value, $old_value) {
  return sf_handle_img_upload(
    $new_value, 
    $old_value, 
    THEME_PREFIX.'logo_img_upload', 
    THEME_PREFIX.'delete_logo_img');
}

function sf_handle_favicon_upload($new_value, $old_value) {
  return sf_handle_img_upload(
    $new_value, 
    $old_value, 
    THEME_PREFIX.'favicon_upload', 
    THEME_PREFIX.'delete_favicon');
}

// Generic Image Upload Handler
function sf_handle_img_upload($new_value, $old_value, $file_index, $delete_field) {
  if ( isset($_POST[$delete_field]) && $_POST[$delete_field]=='true' )
    return '';

  if ( empty($_FILES) || !isset($_FILES[$file_index]) || 0==$_FILES[$file_index]['size'] )
    return $old_value;

  $overrides = array('test_form' => false);
  $file = wp_handle_upload($_FILES[$file_index], $overrides);

  if ( isset($file['error']) )
    wp_die( $file['error'] );

  $url = $file['url'];
  $type = $file['type'];
  $file = $file['file'];
  $filename = basename($file);

  // Construct The Object Array
  $object = array(
		  'post_title' => $filename,
		  'post_content' => $url,
		  'post_mime_type' => $type,
		  'guid' => $url
		  );

  // Save The Data
  $id = wp_insert_attachment($object, $file);

  // Add The Meta
  wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );

  do_action('wp_create_file_in_uploads', $file, $id); // For replication
  return esc_url($url);
}

function sf_sideblog_admin() {

	$option_fields = array();

	if ( $_GET['updated'] ) echo '<div id="message" class="updated fade"><p>SoWink Theme Options Saved.</p></div>';
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/functions.css" type="text/css" media="all" />';
	
	// Accordion Script
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/scripts/accordion/style.css" type="text/css" media="all" />';
	echo '<script src="'.get_bloginfo('template_url').'/scripts/accordion/jquery.ui.js" type="text/javascript"></script>';
	echo '<script src="'.get_bloginfo('template_url').'/scripts/accordion/jquery.accordion.js" type="text/javascript"></script>';
	
	// Color Picker Script
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/scripts/colorpicker/style.css" type="text/css" media="all" />';
	echo '<script src="'.get_bloginfo('template_url').'/scripts/colorpicker/jquery.colorpicker.js" type="text/javascript"></script>';
	echo '<script src="'.get_bloginfo('template_url').'/scripts/colorpicker/jquery.eye.js" type="text/javascript"></script>';
	
	// Styling File Form Elements
	echo '<script src="'.get_bloginfo('template_url').'/scripts/si.files.js" type="text/javascript"></script>';
?>

<div class="wrap">
    <div id="icon-options-general" class="icon32"><br/></div>

    <h2>SoWink Theme Options</h2>
    <div class="metabox-holder">
    	<form method="post" action="options.php" enctype="multipart/form-data">
		<?php wp_nonce_field('update-options'); ?>
    
        <div id="theme-options">
	        <div id="accordion" class="postbox-container">
	            <?php
	            	include("options/custom-logo.php");
	            	include("options/custom-favicon.php");
	            	include("options/custom-menus.php");
	            	include("options/custom-styles.php");
	            	include("options/gravity-forms.php");
	        		include("options/footer-text.php");
	        		include("options/google-analytics.php");
	        		include("options/save-the-web.php");
	        	?>
	        </div> <!-- postbox-container -->
        </div> <!-- theme-options -->
        
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="<?php echo implode(",", $option_fields); ?>" />
        </form>
        
        <script type="text/javascript" language="javascript">SI.Files.stylizeAll();</script>
    </div> <!-- metabox-holder -->
</div> <!-- wrap -->

<?php
}

// Custom Video Function
function get_video($postID) {
	if( function_exists('p75GetVideo') ) {
		$video = p75GetVideo($postID);
		return $video ? "<div class='video-embed'>" . $video . "</div>" : "";
	}
	return "";
}

// Custom Excerpt Length
function new_excerpt_length($length) {
	return 40;
}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($more) {
	return ' ...';
}
add_filter('excerpt_more', 'new_excerpt_more');

// Short Title Function
function the_short_title($before = '', $after = '', $echo = true, $length = false) {
	$title = get_the_title();
	
	if ( $length && is_numeric($length) ) {
		$title = substr( $title, 0, $length );
	}
	
	if ( strlen($title)> 0 ) {
		$title = apply_filters('the_short_title', $before . $title . $after, $before, $after);
		if ( $echo )
			echo $title;
		else
			return $title;
	}
}

// Custom Pagination Function
function sf_pagenavi($before = '', $after = '', $prelabel = '', $nxtlabel = '', $pages_to_show = 5, $always_show = false) {
	global $request, $posts_per_page, $wpdb, $paged;
	if(empty($prelabel)) {   $prelabel = '';
		} if(empty($nxtlabel)) {
		$nxtlabel = '';
	} $half_pages_to_show = round($pages_to_show/2);
	if (!is_single()) {
		if(!is_category()) {
		preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);  } else {
		preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);  }
		$fromwhere = $matches[1];
		$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
		$max_page = ceil($numposts /$posts_per_page);
		if(empty($paged)) {
			$paged = 1;
		}
		if($max_page > 1 || $always_show) {
			echo "$before <div id='paginate'>Pages ... ";   if ($paged >= ($pages_to_show-1)) {
			echo '';  }
			previous_posts_link($prelabel);
			for($i = $paged - $half_pages_to_show; $i <= $paged + $half_pages_to_show; $i++) {   if ($i >= 1 && $i <= $max_page) {   if($i == $paged) {
						echo "$i";
						} else {
					echo ' <a href="'.get_pagenum_link($i).'">'.$i.'</a> ';   }
				}
			}
			next_posts_link($nxtlabel, $max_page);
			if (($paged+$half_pages_to_show) < ($max_page)) {
			echo '';   }
			echo "</div> $after";
		}
	}
}

// Sidebar Widgets
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Home Page',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Multiple Post Pages',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Single Post Pages',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Page Pages',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));

// Add favicon to admin area
function admin_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/images/favicon-admin.ico" />';
}
add_action('admin_head', 'admin_favicon');
add_action( 'login_head', 'admin_favicon' );

//deactivate WordPress function
remove_shortcode('gallery', 'gallery_shortcode');

//activate own function
add_shortcode('gallery', 'wpe_gallery_shortcode');

// Gallery link to large image instead of full size
function wpe_gallery_shortcode($attr) {
	global $post, $wp_locale;

	static $instance = 0;
	$instance++;

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$output = apply_filters('gallery_style', "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->
		<div id='$selector' class='gallery galleryid-{$id}'>");

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
		$img_replace = wp_get_attachment_image($id, 'large', $icon = false);
		$start=strpos($img_replace,'src="')+5;$end=strrpos($img_replace,'.jpg')+4;
		$img_replace = substr($img_replace,$start,$end-$start);
		//echo($img_replace);
		$img_original = wp_get_attachment_image($id, 'full', $icon = false);
		$start=strpos($img_original,'src="')+5;$end=strrpos($img_original,'.jpg')+4;
		$img_original = substr($img_original,$start,$end-$start);
		//echo($img_original);
		$link=str_replace($img_original,$img_replace,$link);
		
		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon'>
				$link
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both" />';
	}

	$output .= "
			<br style='clear: both;' />
		</div>\n";

	return $output;
}

// Hide update nag
add_action('admin_menu','wphidenag');
function wphidenag() {
    remove_action( 'admin_notices', 'update_nag', 3 );
}

// Limit Excerpt to 80 characters
the_excerpt_max_charlength(140);

function the_excerpt_max_charlength($charlength) {
   $excerpt = get_the_excerpt();
   $charlength++;
   if(strlen($excerpt)>$charlength) {
       $subex = substr($excerpt,0,$charlength-5);
       $exwords = explode(" ",$subex);
       $excut = -(strlen($exwords[count($exwords)-1]));
       if($excut<0) {
            echo substr($subex,0,$excut);
       } else {
            echo $subex;
       }
       echo "[...]";
   } else {
       echo $excerpt;
   }
}

// Custom login page.
add_action('login_head', 'custom_login');
function custom_login() { 
echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/login.css" />'; 
}

?>
