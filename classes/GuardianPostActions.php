<?php
/*
Class Name: GuardianPostActions
Description: Extends PostActions. This class contains all post actions that are specific to the Guardian Plugin
Author: M Purnell
Author URI: www.markpurnell.co.uk
*/
include 'PostActions.php';

	class GuardianPostActions extends PostActions{

		//create all guardian posts from an object
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
			$posts = $this->getGuardianPosts();
			foreach($posts as $post){
				wp_delete_post($post->ID);
			}
			$pageID = $this->getIDByTitle('What the world is saying about fish');
			wp_delete_post($pageID);
		}

		//retrieve the entire list of guardian posts
		public function getGuardianPosts(){
			$args = array( 
			    'post_type' 	=> 'Guardian',
			    'numberposts'	=> 10
			);
			$posts = get_posts($args);
			return $posts;
		}

		//update the meta of the guardian posts
		public function updateGuardianPosts($query){
			//get the new posts
			include_once 'GuardianRSSManager.php';
			$rssManager = new GuardianRSSManager();
			$newPosts = $rssManager->searchGuardianAPI($query = 'fish');

			//delete the old posts, create the new ones
			$this->deleteGuardianPosts();
			$this->createGuardianPosts($newPosts);
		}
	}
?>