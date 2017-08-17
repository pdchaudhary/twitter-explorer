<?php
	require_once('config.php');

	if(isset($_SESSION['twitter_oauth'])){
		jsonResponse([
			"status" => 1,
			"user" => getTwitterUser()
		]);
	}else{
		jsonResponse([
			"status" => 0,
			"user" => null
		]);
	}
?>