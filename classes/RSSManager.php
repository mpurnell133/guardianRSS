<?php
/*
Class Name: RSSManager
Description: Handles all actions regaarding page creation, page deletion, and page modification
Author: M Purnell
Author URI: www.markpurnell.co.uk
*/
	class RSSManager{
		//get an array of post objects from the guardian API
		public function searchGuardianAPI($query){
			//get info from an API request
			$RSS_json = getRSSasJSON('http://content.guardianapis.com/search?q='.$query.'&format=json&show-fields=thumbnail%2Cstandfirst');
			$postMetaData = array();
			$i = 0;

			//store eacb post within an array
			foreach($RSS_json->response->results as $result){
				$postMetaData[$i]->title = $result->webTitle;
				$postMetaData[$i]->summary = $result->fields->standfirst;
				$postMetaDat[$i]->thumbnail = $result->fields->thumbnail;
				$postMetaData[$i]->link = $result->webUrl;
				i++;
			}
			return $postMetadata;
		}
		//get a JSON string from a url, and return it as a JSON file
		private function getRSSasJSON($url){
			$RSS_string = get_file_contents($url);
			$RSS_json = json_decode($RSS_string);
			return $RSS_json
		}
	}
?>