<?php
	require_once('config.php');

	
	$followers = $twitter->get('followers/list');
	
	jsonResponse([
		"status" => 1,
		"followers" => $followers->users
	]);
 ?>