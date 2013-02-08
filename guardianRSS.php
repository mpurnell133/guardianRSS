<?php
/*
Plugin Name: GuardianRSS
Description: Takes the top ten entries from the search 'fish' using the guardian's API, and stores them in post format on a page. Uses cron jobs to update the posts every 8 hours.
Version: 0.1
Author: M Purnell
Author URI: www.markpurnell.co.uk n
Plugin URI: https://github.com/mpurnell133/guardianRSS
*/

	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors',1);

	include 'classes/GuardianRSSManager.php';
	include 'classes/GuardianPostActions.php';

	//wordpress hooks
	register_activation_hook(__FILE__, 'onActivate');
	register_deactivation_hook(__FILE__, 'onDeactivate');
	add_action('init', 'guardian_post_init');

	//on plugin activation
	function onActivate(){
		//create the 'what the world is saying about fish' page
		$postActions = new GuardianPostActions();
		$postActions->createPost('What the world is saying about fish', 'page', 'publish', '[guardian]');

		//create each individual post, and populate them with metadata from the guardian API
		$rssManager = new GuardianRSSManager();
		$posts = $rssManager->searchGuardianAPI('fish');
		$postActions->createGuardianPosts($posts);
	}

	//on plugin deactivation
	function onDeactivate(){
		//delete the page
		$postActions = new GuardianPostActions();
		$postActions->deleteGuardianPosts();
	}

	//initialization of the custom "guardian" post
	function guardian_post_init() {
		$labels = array(
			'name' => 'Guardian',
			'singular_name' => 'Guardian',
			'add_new' => null,
			'add_new_item' => 'Add New Post',
			'edit_item' => 'Edit Post',
			'new_item' => 'New Post',
			'all_items' => 'All Posts',
			'view_item' => 'View Post',
			'search_items' => 'Search the Guardian Feed',
			'not_found' =>  'No Posts Found',
			'not_found_in_trash' => 'No posts found in trash', 
			'parent_item_colon' => '',
			'menu_name' => 'Guardian'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => array( 'slug' => 'Guardian' ),
			'capability_type' => 'post',
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => 5,
			'supports' => array('title', 'custom-fields')
		);
		register_post_type('guardian', $args);
	}
?>