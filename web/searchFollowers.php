<?php
session_start();
require_once('jsonResponder.php');
$followers = $_SESSION['twitter_oauth']['followers'];


$searchQuery = $_GET['query'];
$searchedFollwers = [];
foreach ($followers as $follower) {
	if(strpos(strtolower($follower->name), strtolower($searchQuery)) !== false){
		$searchedFollwers[] = [
			'follower' => $follower,
			'rank' => strpos(strtolower($follower->name), strtolower($searchQuery))
		];
	}
}

usort($searchedFollwers, function($a, $b) {
    return $a['rank'] - $b['rank'];
});

$responseFollowers = [];
foreach ($searchedFollwers as $follower) {
	$responseFollowers[] = $follower['follower'];
}

jsonResponse([
	"status" => 1,
	"followers" => $responseFollowers
]);