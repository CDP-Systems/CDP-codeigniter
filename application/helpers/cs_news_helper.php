<?php

if (!function_exists('create_news_url'))
{
	function create_news_url($news_title){
		
		$url_key = strtolower($news_title);
		
		$url_key = trim(preg_replace('/-/', '', $url_key));
		
		$url_key = preg_replace('/[\s]+/', '-', $url_key);
		
		return $url_key;
	
	}

}

if (!function_exists('return_news_title_from_url'))
{
	function return_news_title_from_url($news_url_key){
		
		$news_title = trim(preg_replace('/-/', ' ', $news_url_key));
		
		$news_title = ucwords($news_title);
		
		return $news_title;
	
	}

}
?>