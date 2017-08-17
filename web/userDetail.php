<?php
require_once('config.php');
jsonResponse([
	"status" => 1,
	"userdetail" => $_SESSION['twitter_oauth']['user']
]);

?>