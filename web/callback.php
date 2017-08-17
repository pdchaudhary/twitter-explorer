<?php
require_once('config.php');
$access_token = $twitter->oauth("oauth/access_token", $_GET);
$_SESSION['twitter_oauth'] = $access_token;
//header("Location: " . getServerURL() . "/index.php");


function getServerURL(){
	return $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'];
}
?>

<script type="text/javascript">
	window.opener.checkTwitterLogin(window);
</script>