<?php
require_once('config.php');
$_SESSION['twitter_oauth']['followers'] = [];
$page=10;
$followers = $twitter->get('followers/ids', ['count' => 5000]);
//print_r($followers); exit;
do{
	$array_offset = 0;
	while(sizeof($folloerIds = array_slice($followers->ids, $array_offset, 100)) > 0){
		$followersInfoArray = $twitter->post('users/lookup',['user_id' => join(',', $folloerIds)]);
		$_SESSION['twitter_oauth']['followers'] = array_merge($_SESSION['twitter_oauth']['followers'], $followersInfoArray);	
		$array_offset += 100;
	}
	$followers = $twitter->get('followers/ids', ['count' => 5000, 'cursor' => $followers->next_cursor]);
} while ($followers->next_cursor > 0);


jsonResponse([
	"status" => 1,
	"followers" => $_SESSION['twitter_oauth']['followers']
]);