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
    
    // it gets the first picture from the gallery. Note: the order of the
    // images in the gallery is independent from the order in that they 
    // show up in the post
    $picture = get_images_from_post($post_id);
    // if there's no images at all, it falls back to a default image
    if(!isset($picture)) $picture = SOWINK_AVATAR_IMAGE_URL;
  
    $body = array(				
        'post_id' => $post_to_send->ID,
        'creator' => 1,
        'created' => $post_to_send->post_date,
        'title' => $post_to_send->post_title,
        'html' => $post_to_send->post_content,
        'picture' => $picture,
        'for_user' => 2,
        'blog_auth_key' => BLOG_AUTH_KEY 
    );

    $url = CREATEPOST_BLOG_URL;
    $request = new WP_Http;
    $result = $request->request($url, 
                                array('method' => 'POST', 
                                      'body' => $body) );
    return $result['response']['body'];
}

function get_images_from_post($post_id){
    // Get images for this post
    $arrImages =& get_children(
            'post_type=attachment&post_mime_type=image&post_parent='.
             $post_id);
 	    
    // If images exist for this page
    if($arrImages){
 
        // Get array keys representing attached image numbers
        $arrKeys = array_keys($arrImages);
  
        // Get the first image attachment
        $iNum = $arrKeys[0];
 
        // Get the thumbnail url for the attachment
        // $sThumbUrl = wp_get_attachment_thumb_url($iNum);
 
        // Full size image instead of the thumbnail
        $sImageUrl = wp_get_attachment_url($iNum);

        return($sImageUrl);
    }
}

do_action( 'send_post_to_newsfeed', $post_id );
add_action('publish_post', 'send_post_to_newsfeed');

?>