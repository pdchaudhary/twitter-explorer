<?php
	require_once('config.php');
	unset($_SESSION['twitter_oauth']);
	$loggedIn = isset($_SESSION['twitter_oauth']);

	$twitterLoginURL = getTwitterLoginURL();
	jsonResponse([
		"status" => !isset($_SESSION['twitter_oauth']) ? 1 : 0,
		"url" => $twitterLoginURL
	]);

?>