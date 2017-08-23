<?php
require_once('config.php');

$searchQuery = $_GET['query'];
$twitterUsers = $twitter->get('users/search', ['q' => $searchQuery, 'count' => 15, 'include_entities' => false]);

jsonResponse([
	"status" => 1,
	"users" => $twitterUsers
]);