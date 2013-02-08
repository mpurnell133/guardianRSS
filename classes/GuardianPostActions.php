<?php
/*
Class Name: GuardianPostActions
Description: Extends PostActions. This class contains all post actions that are specific to the Guardian Plugin
Author: M Purnell
Author URI: www.markpurnell.co.uk
*/
include 'postActions.php';

	class GuardianPostActions extends PostActions{

		//create the list of guardian posts
		public function createGuardianPosts($posts){
			foreach($posts as $post){
				$postID = $this->createPost($post->title, 'guardian', 'publish');
				add_post_meta($postID, "summary", $post->summary);
				add_post_meta($postID, "thumbnail", $post->thumbnail);
				add_post_meta($postID, "link", $post->link);
			}
		}

		//delete all guardian posts
		public function deleteGuardianPosts(){
			$posts = getGuardianPosts();
			foreach($posts as $post){
				wp_delete_post($post->ID);
			}
			$pageID = $this->getIDByTitle('What the world is saying about fish');
			wp_delete_post($pageID);
		}

		//retrieve the list of guardian posts
		private function getGuardianPosts(){
			$args = array( 
			    'post_type' 	=> 'Guardian',
			    'numberposts'	=> 10
			);
			$posts = get_posts($args);
			return $posts;
		}

		//update the meta of the guardian posts
		public function updateGuardianMeta(){
			$posts = getGuardianPosts();
			foreach($posts as $post){
			error_log("RETURNING POST OBJECT");
				error_log(print_r($post, 1));
				add_post_meta($postID, "summary", $post->summary);
				add_post_meta($postID, "thumbnail", $post->thumbnail);
				add_post_meta($postID, "link", $post->link);
			}
		}
	}
?>