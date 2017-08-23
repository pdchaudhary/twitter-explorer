<?php
require_once('config.php');
use Knp\Snappy\Pdf;
ini_set('max_execution_time', 300);

$userTwitterHandle = isset($_GET['handle']) ? $_GET['handle'] : $_SESSION['twitter_oauth']['user']['screen_name'];
$userTweets = [];
$page = 1;
while (sizeof($myTweets = $twitter->get('statuses/user_timeline', ['screen_name' => $userTwitterHandle, 'count' => 200, 'page' => $page++])) > 0) {
	$userTweets = array_merge($userTweets, $myTweets);
}

setPDFHeaders();
$snappy = new Pdf(realpath('../vendor/bin/wkhtmltopdf.exe.bat'));
echo $snappy->getOutputFromHTML(createTweetsHTML($userTweets));



function setPDFHeaders(){
    global $userTwitterHandle;
    header('Content-Type: application/pdf');
    header("Content-Disposition: attachment; filename={$userTwitterHandle}_tweets.pdf");
    header("Pragma: no-cache");
    header("Expires: 0");
}

function createTweetsHTML($tweets){
    $html = '<!DOCTYPE html><html><head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></head><body>';
    $html .= '<div class="container">';

    foreach ($tweets as $key => $tweet) {
        if($key%2 == 0) { $html .= '<div class="row">'; }

        $html .= '<div class="col-xs-6"><div class="panel panel-default" ><div class="panel-heading" >';
        $html .= $tweet->user->name;
        $html .= '</div>';
        $html .= '<div class="panel-body" style="border-bottom: 1px solid #ddd;">';
        $html .= $tweet->text;
        $html .= '</div>';
        $html .= '<div class="panel-body" style="border-bottom: 1px solid;">';
        $html .= (new DateTime($tweet->created_at))->format("h:i A d M, Y");
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        if($key%2 != 0) { $html .= '</div>'; }
    }

    $html .= '</div></body></html>';

    return $html;
}
?>