<?php
/*
Class Name: PostActions
Description: Handles all actions regaarding page creation, page deletion, and page modification
Author: M Purnell
Author URI: www.markpurnell.co.uk
*/
	//see desc
	class PostActions(){
		//delete WP post from DB
		public function deletePostByTitle($title){
			$page = get_page_by_title($title);
			$pageID = $page->ID;
			wp_delete_post($pageID);
		}

		//create and insert post into WP DB. Returns the WP ID of the post
		public function createPost($title, $type, $status, $content = '', $parent = ''){
			$post = [
				'post_type' 	=> $type,
				'post_title' 	=> $title,
				'post_content'	=> $content,
				'post_status'	=> $status,
				'post_parent'	=> $parent
			];
			return $wp_insert_post($post);
		}
	}
?>