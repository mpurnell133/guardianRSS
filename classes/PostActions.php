<?php
/*
Class Name: PostActions
Description: Handles all basic page/post related actions
Author: M Purnell
Author URI: www.markpurnell.co.uk
*/
	class PostActions{
		//get a post's ID by it's title
		public function getIDByTitle($title){
			$post = get_page_by_title($title);
			$postID = $post->ID;
			return $postID;
		}

		//create and insert post into WP DB. Returns the WP ID of the post upon creation
		public function createPost($title, $type, $status, $content = ''){
			$post =  array(
				'post_title' 	=> $title,
				'post_type' 	=> $type,
				'post_status'	=> $status,
			);
			return wp_insert_post($post);
		}
	}
?>