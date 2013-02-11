<?php
/*
Plugin Name: GuardianRSSProject
Description: Takes the top ten entries from the search 'fish' using the guardian's API, and stores them in post format on a page.
Version: 0.1
Author: M Purnell
Author URI: www.markpurnell.co.uk n
Plugin URI: https://github.com/mpurnell133/guardianRSS
*/

	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors',1);
	include_once 'classes/GuardianRSSManager.php';
	include_once 'classes/GuardianPostActions.php';
	include_once 'widgets/TestWidget.php';
	$widget = new TestWidget();
	add_action( 'widgets_init', create_function( '', 'register_widget( "TestWidget" );' ) );


	//wordpress hooks
	register_activation_hook(__FILE__, 'onActivate');
	register_deactivation_hook(__FILE__, 'onDeactivate');
	add_action('init', 'guardian_post_init');

	add_shortcode('guardian', 'displayFeed');

	//on plugin activation
	function onActivate(){
		$postActions = new GuardianPostActions();
		$rssManager = new GuardianRSSManager();
		
		//create the 'what the world is saying about fish' page
		$postActions->createPost('What the world is saying about fish', 'page', 'publish', '[guardian]');

		//create a list of guardian posts, and populate them with metadata from the guardian API
		$posts = $rssManager->searchGuardianAPI();
		$postActions->createGuardianPosts($posts);
	}

	//on plugin deactivation
	function onDeactivate(){
		//delete the page
		$postActions = new GuardianPostActions();
		$postActions->deleteGuardianPosts();
		delete_option('search');
	}

	//display the content of the guardian posts on pages with the [guardian] shortcode
	function displayFeed(){
		$posts = $postActions->getGuardianPosts();
		foreach($posts as $post){
			$title = $post->post_title;
			$summary = get_post_meta($post->ID, 'summary', 1);
			$thumbnail = get_post_meta($post->ID, 'thumbnail', 1);
			$link = get_post_meta($post->ID, 'link', 1);

			echo("<h1>".$title."</h1>");
			echo("<p>".$summary."</p>");
			echo("<img src='".$thumbnail."' />");
			echo("<p><a href='".$link."'>".$link."</a></p>");
			echo("<hr />");
		}
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