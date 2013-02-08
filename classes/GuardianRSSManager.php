<?php
/*
Class Name: RSSManager
Description: Handles all actions regarding the retreival of data/information from the guardian API
Author: M Purnell
Author URI: www.markpurnell.co.uk
*/

	class GuardianRSSManager{
		//return an array of post objects from the guardian API
		public function searchGuardianAPI($query){
			//get info from an API request
			$RSS_json = $this->getRSSasJSON('http://content.guardianapis.com/search?q='.$query.'&format=json&show-fields=thumbnail%2Cstandfirst');
			$response = $RSS_json->response;
			$results = $response->results;
			$posts= array();
			$i = 0;

			//store eacb post within an array
			foreach($results as $result){
				$field = $result->fields;

				//check if the properties exist (one object returned without a thumbnail) If they don't, then create the values with blank properties
				if(isset($result->webTitle))	{$title = $result->webTitle;}				else{$webTitle	= '';}
				if(isset($field->standfirst))	{$summary = $field->standfirst;}			else{$summary	= '';}
				if(isset($field->thumbnail))	{$thumbnail =$field->thumbnail;}			else{$thumbnail	= '';}
				if(isset($result->webUrl))		{$link = $result->webUrl;}					else{$link		= '';}

				//all posts are stored in an object: if no information is found, objects are filled with blank content
				$post = (object) array(
					'title' 	=> $title,
					'summary' 	=> $summary,
					'thumbnail' => $thumbnail,
					'link' 		=> $link
				);
				$posts[$i] = $post;
				$i++;
			}
			return $posts;
		}
		
		//get a JSON string from a url, and return it as a JSON file
		private function getRSSasJSON($url){
			$RSS_string = file_get_contents($url);
			$RSS_json = json_decode($RSS_string);
			return $RSS_json;
		}
	}
?>