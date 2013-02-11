<?php
/*
Script Name: update.php
Description: Called every 8 hours to refresh the Meta values of the guardian posts
Author: M Purnell
Author URI: www.markpurnell.co.uk
*/
	include_once 'classes/GuardianPostActions.php';
	$postActions = new GuardianPostActions();
	$postActions->updateGuardianPosts();

?>