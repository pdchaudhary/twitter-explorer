<?php
session_start();
$consumerKey    = 'TWITTER_CONSUMENR_KEY';
$consumerSecret = 'TWITTER_CONSUMENR_SECRET';

require_once('../vendor/autoload.php');
require_once('jsonResponder.php');
use Abraham\TwitterOAuth\TwitterOAuth;

$loggedIn = isset($_SESSION['twitter_oauth']); 

if($loggedIn){
	$twitter = new TwitterOAuth($consumerKey, $consumerSecret, $_SESSION['twitter_oauth']['oauth_token'], $_SESSION['twitter_oauth']['oauth_token_secret']);
	$twitterUser = $twitter->get("account/verify_credentials");
	$_SESSION['twitter_oauth']['user'] = $twitterUser;
}else{
	$twitter = new TwitterOAuth($consumerKey, $consumerSecret, '', '');
}


function getTwitterLoginURL(){
	global $loggedIn;
	if($loggedIn){
		return "#";
	}

    global $twitter;
    $access_token = $twitter->oauth("oauth/request_token", ["oauth_callback" => $_SERVER['REQUEST_SCHEME'] ."://" .$_SERVER['SERVER_NAME']."/callback.php"]);
    $login_url = $twitter->url("oauth/authenticate", ["oauth_token" => $access_token["oauth_token"]]);
    return $login_url;
}

function getTwitterUser(){
    return $_SESSION['twitter_oauth']['user'];
}

function getTwitterUserName(){
	global $loggedIn;
	if(!$loggedIn){
		return "Twitter User";
	}
    return $_SESSION['twitter_oauth']['user']->name;
}

function getTwitterUserURL(){
	global $loggedIn;
	if(!$loggedIn){
		return "#";
	}

    return "https://twitter.com/" . $_SESSION['twitter_oauth']['user']->screen_name;
}

function getTwitteruserprofileURL(){
	global $loggedIn;
	if(!$loggedIn){
		return "#";
	}
	return $_SESSION['twitter_oauth']['user']->profile_image_url_https;

}


?>
