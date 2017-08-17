<?php
require_once('config.php');
ini_set('max_execution_time', 300);
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=MyTweets.csv");
header("Pragma: no-cache");
header("Expires: 0");

$csvFile = fopen("php://output", "w");
$myfild=array('Time','Tweets','retweet_count','favorite_count');
fputcsv($csvFile,$myfild);

$page = 1;
while (sizeof($myTweets = $twitter->get('statuses/user_timeline', ['count' => 200, 'page' => $page++])) > 0) {
	outputCSV($myTweets);
}
fclose($csvFile);


function outputCSV($myTweets) {
	global $csvFile;
	
    foreach ($myTweets as $tweet) {
    	$row = [];
    	$tweet_time = new DateTime($tweet->created_at);
    	$tweet_time->setTimezone(new DateTimeZone('Asia/Kolkata'));
    	$row[] = $tweet_time->format('Y-m-d h:i A');
    	$row[] = $tweet->text;
    	$row[] = $tweet->retweet_count;
    	$row[] = $tweet->favorite_count;
        fputcsv($csvFile, $row);
    }
}    
?>