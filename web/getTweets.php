<?php
require_once('config.php');

$tweets = $twitter->get("statuses/home_timeline", ['count' => 6]);
$tweetEmbedHtmls = []; 
foreach ($tweets as $tweet) {
	$embedResponse = $twitter->get("statuses/oembed", ['url' => getTweetLink($tweet)]);
	$tweetEmbedHtmls[] = $embedResponse->html;
}

function getTweetLink($tweet){
	return "https://twitter.com/" . $tweet->user->screen_name . "/status/" . $tweet->id_str;
}

jsonResponse([
	"status" => 1,
	"tweets" => $tweetEmbedHtmls
]);




?>