<?php
require_once('config.php');
jsonResponse([
	"status" => 1,
	"user" => $_SESSION['twitter_oauth']['user']
]);

?>