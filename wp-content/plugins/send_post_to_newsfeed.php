<?php
/*
Plugin Name: Send Post to SoWink newsfeed
Plugin URI: ...
Description: Extracts info from a WP post upon creation and sends it to a SoWink API url via http POST
Author: David Dul @ SoWink
Version: 0.1
Author URI: http://sowink.com/
*/ 
                                                                              
function send_post_to_newsfeed($post_id){

    $post_to_send = get_post($post_id);
    
    // It gets the first picture from the gallery (order field ==1 ).
    // Note: the order of the images in the gallery is independent 
    // from the order in that they show up in the blogpost.
    $picture = get_order1_img_from_post($post_id);
    
    // Get the summary custom field.
    $summary = get_post_meta($post_id, 'Summary', TRUE);
    // Check if it's null or an emty string.
    if(!isset($summary) || 
    		(strlen(trim(preg_replace('/\xc2\xa0/',' ',$s))) == 0)){
      	// Truncate text (but keep whole words) 
        $text = substr($post_to_send->post_content,0,TRUNCATE_BLOGPOST); 
        $text = substr($text,0,strrpos($text,' '));
        $text = $text."..."; 
    	$html = $text;
    }
    else $html = $summary;
  	  	
    $body = array(				
        'post_id' => $post_to_send->ID,
        'creator' => 1,
        'created' => $post_to_send->post_date,
        'title' => $post_to_send->post_title,
        'html' => $html,
        'picture' => $picture,
        'for_user' => 2,
        'blog_auth_key' => BLOG_AUTH_KEY 
    );

    $request = new WP_Http;
    $result = $request->request(CREATEPOST_BLOG_URL, 
                                array('method' => 'POST', 
                                      'body' => $body) );
    return $result['response']['body'];
}

function get_order1_img_from_post($post_id){

	// Get first image
 	$args = array(
		'post_mime_type' => 'image',
		'post_parent' => $post_id,
		'post_status' => null,
		'post_type' => 'attachment'
	);
 	$images = get_children($args);
 	 	
    // If images exist for this page then take the one that has it's order
    // field set to 1 (wp admin area)
    if($images){
        $img_url = '';
 		foreach ($images as $image){
 			if ($image->menu_order == 1)
				return $image->guid;
		} 
    } 
}

do_action( 'send_post_to_newsfeed', $post_id );
add_action('publish_post', 'send_post_to_newsfeed');

?>