<?php
/*
Class Name: PostActions
Description: Handles all actions regaarding page creation, page deletion, and page modification
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

		//delete all children of a post
		public function deleteGuardianPosts(){
			$args = array( 
			    'post_type' 	=> 'Guardian',
			    'numberposts'	=> 10
			);
			$posts = get_posts($args);
			error_log('START');
			error_log(print_r($posts, 1));
			foreach($posts as $post){
				wp_delete_post($post->ID);
			}
			$page = get_page_by_title('What the world is saying about fish');
			$pageID = $page->ID;
			wp_delete_post($pageID);
		}

		//create and insert post into WP DB. Returns the WP ID of the post
		public function createPost($title, $type, $status){
			$post =  array(
				'post_title' 	=> $title,
				'post_type' 	=> $type,
				'post_status'	=> $status,
			);
			return wp_insert_post($post);
		}
	}
?>