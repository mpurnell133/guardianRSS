<?php
/*
Plugin Name: guardianRSS
Description: Takes the top ten entries from the search 'fish' using the guardian's API, and stores them in post format on a page. Uses chronjobs to update the posts every 8 hours.
Version: 0.1
Author: M Purnell
Author URI: www.markpurnell.co.uk
Plugin URI: http://authorsite.com/msp-helloworld
*/
	include 'RSSManager.php';
	include 'pageActions.php';

	//wordpress hooks
	register_activation_hook('onActivate');
	register_deactivation_hook('onDeactivate');

		//on plugin activation
		function onActivate(){
			//create the 'what the world is saying about fish' page
			$pageActions = new PageActions();
			$parentID = $pageActions->createPost('What the world is saying about fish', 'page', 'publish');

			//create each individual post, and populate them with metadata from the guardian API
			$rssManager = new RSSManager();
			$postMeta = $rssManager->searchGuardianAPI('fish');
			foreach($postMeta as $post){
				$postID = $pageActions->createPost($post->title, 'post', 'publish', '', $parentID);
			}
		}
		//on plugin deactivation
		function onDeactivate(){
			//delete the page
			$pageActions = new PageActions();
			$pageActions->deletePageByTitle('What the world is saying about fish');
		}
	}
?>