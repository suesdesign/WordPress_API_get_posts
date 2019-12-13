<?php
/**
 * @package Suesdesign API
 * @version 1.0
 */
/*
Plugin Name: Suesdesign WordPress API Posts
Plugin URI: http://suesdesign.co.uk/
Description: Get posts using the WordPress API
Author: Sue Johnson
Version: 1.0
Author URI: http://suesdesign.co.uk/
*/

class Suesdesign_Get_Posts
{
    // GET the remote site
    private $url = 'http://localhost/wordpresstest/wp-json/wp/v2/posts';
    public function __construct() {
    // Add_shortcode    
        add_shortcode('get_json', array($this, 'get_json_posts'));
    }
    public function get_json_posts() {
        $this->response = wp_remote_get( $this->url );
        $posts = json_decode( wp_remote_retrieve_body( $this->response ) );
        $allposts = '';
    // Check for error
        if ( !$posts  ) {
            return sprintf( '<p>The URL %1s could not be retrieved.</p>', $this->url ); //get just the body
        } else {
    // Loop through posts
        
        foreach ( $posts as $post ) {
    // Format the date.
    		$fordate = date( 'n/j/Y', strtotime( $post->modified ) );
    // Show a title, post date and content
    		$allposts .= '<h2>' . $post->title->rendered . '</h2>';
            $allposts .= '<p>' . $fordate . '</p>';
    		$allposts .= $post->content->rendered;
    	}
    	return $allposts;
        }
    }
}

new Suesdesign_Get_Posts();
