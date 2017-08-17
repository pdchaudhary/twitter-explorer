<?php 
	require_once('config.php');
	$twitterLoginURL = getTwitterLoginURL();
	jsonResponse([
		"status" => $twitterLoginURL == "#" ? 0 : 1,
		"url" => $twitterLoginURL
	]);
?>