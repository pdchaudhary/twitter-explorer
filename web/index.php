<?php 
    require_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Twitter Explorer - Assignment</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="/css/styles.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/redmond/jquery-ui.css">
        <link rel="stylesheet" href="/css/jquery.bxslider.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
        <style type="text/css">
            <?php if($loggedIn) { ?>
                div.navbar-guest-user{
                    display: none;
                }
                div.navbar-twitter-user{
                    display: block;
                }
            <?php }else{ ?>
                div.navbar-guest-user{
                    display: block;
                }
                div.navbar-twitter-user{
                    display: none;
                }
            <?php } ?>
            <?php if($loggedIn) { ?>
                div.panel.panel-default{
                    display: block;
                }
                div.panel.panel-default.twitter-login{
                    display: none;
                }
            <?php }else{ ?>
                div.panel.panel-default{
                    display: none;
                }
                div.panel.panel-default.twitter-login{
                    display: block;
                }
            <?php } ?>
        </style>
    </head>

    <body>
        <nav class="navbar navbar-toggleable-md navbar-default ">
            <div class="container-fluid ">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Twitter Explorer</a>
                </div>
                <!--Guest User Markup-->
                <div class="navbar-header navbar-right navbar-guest-user">
                    <a class="navbar-brand">Guest User</a>
                </div>
                <!--End Guest User Markup-->
                <!--Twitter User Markup-->
                <div class="navbar-header navbar-right navbar-twitter-user">
                    <ul class="nav navbar-nav collapse navbar-collapse" id="myNavbar">
                        <li class="dropdown">
                            <a class="dropdown-toggle navbar-twitter-user-url" data-toggle="dropdown" target="_blank" href="<?php echo getTwitterUserURL();?>">
                                <img src="<?php echo getTwitteruserprofileURL();?>" style="margin-right: 10px;" class="navbar-twitter-user-profile profileimg">
                                <span class="navbar-twitter-user-name profilename"  style="margin-right: 10px;"><?php echo getTwitterUserName();?></span>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-profile"><a class="user-profile" >Profile</a></li>
                                <li><a href="#" class="twitter-user-logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!--End Twitter User Markup-->
            </div>
        </nav>
        <div class="container">
            <!--Twitter Login Button Markup-->
            <div class="panel panel-default twitter-login" >
                <div class="panel-body row">
                    <div class="col-xs-12 col-md-12" style="font-size: 23px; text-align: center;">
                        <button data-href="<?php echo getTwitterLoginURL(); ?>" class="btn btn-info btn-twitter-login">Login with Twitter</button>
                    </div>
                </div>
            </div>
            <!--End Twitter Login Button Markup-->
            <!--Twitter Tweets & Followers Markup-->
            <div class="panel panel-default" style="margin-bottom: 0px">
                <div class="panel-body row">
                    <div class="col-xs-6 col-md-6" style="font-size: 23px">Tweets</div>
                    <div class="col-xs-6 col-md-6" style="font-size: 23px; text-align: right;"><a href="/downloadTweets.php" filename="MyTweets.csv" download class="primary">Download</a></div>
                </div>
            </div>
            <div class="panel panel-default" >
                <div class="panel-body tweets">
                    <ul class="tweet-slider">
                    </ul>
                    <div class="loader" style="margin-right: auto;margin-left: auto; margin-top: -50px;"></div>
                </div>
            </div>
            <div class="panel panel-default" style="margin-bottom: 0px">
                <div class="panel-body row">
                    <div class="col-xs-6 col-md-9" style="font-size: 23px">Follower</div>
                    <div class="col-xs-6 col-md-3" >
                        <input type="search" placeholder="Search Followers" class="form-control followers-search">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body followers">
                    <ul class="followers-slider">
                        
                    </ul>
                </div>
            </div>
            <!--End Twitter Tweets & Followers Markup-->
        </div>
        <div class="modal fade follower-info" style="z-index: 9999;" role="dialog">
            <div class="modal-dialog">

            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Twitter User Profile</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="well well-sm">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4">
                                                <img src="" class="followers-search-img" alt="" class="img-rounded img-responsive" style="width="200" height="40"" />
                                            </div>
                                        <div class="col-sm-6 col-md-8">
                                           <a href="" class="follower-profile-links" target="_blank"> <h4 class="followers-search-name"></h4></a>
                                            <a href="" class="follower-profile-links" target="_blank"><h5 class="followers-search-screen_name"></h5></a>
                                            <small>
                                                <cite style="margin-left: 3px;" class="followers-search-location">
                                                    <i class="glyphicon glyphicon-map-marker">
                                                    </i>
                                                </cite>
                                            </small>
                                            <div class="twPc-divStats">
                                                <ul class="twPc-Arrange">
                                                    <li class="twPc-ArrangeSizeFit">
                                                        <a href="#" title="Tweet">
                                                            <span class="twPc-StatLabel twPc-block">Tweets</span>
                                                            <span class="twPc-StatValue followers-search-tweets"></span>
                                                        </a>
                                                    </li>
                                                    <li class="twPc-ArrangeSizeFit" style="width: 100px">
                                                        <a href="https://twitter.com/mertskaplan/following" target="_blank" class="following-links" title="Following">
                                                            <span class="twPc-StatLabel twPc-block">Following</span>
                                                            <span class="twPc-StatValue followers-search-following"></span>
                                                        </a>
                                                    </li>
                                                    <li class="twPc-ArrangeSizeFit">
                                                        <a href="https://twitter.com/mertskaplan/followers" target="_blank" class="followers-Link" title="Followers">
                                                            <span class="twPc-StatLabel twPc-block">Followers</span>
                                                            <span class="twPc-StatValue followers-search-followers"></span>
                                                        </a>
                                                    </li>
                                                     <li class="twPc-ArrangeSizeFit">
                                                        <a href="https://twitter.com/mertskaplan/likes" target="_blank" class="likes-link" title="Likes">
                                                            <span class="twPc-StatLabel twPc-block">Likes</span>
                                                            <span class="twPc-StatValue followers-search-likes"></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>                                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            var userLoggedIn = false;
            <?php if($loggedIn) { ?>
                userLoggedIn = true;
            <?php } ?>
        </script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="/js/jquery.bxslider.min.js"></script>
        <script src="/js/bootstrap-toolkit.min.js"></script>
        <script src="/js/scripts.js"></script>
    </body>

</html>
