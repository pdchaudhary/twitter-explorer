var tweetSlider,followerSlider;

$(document).ready(function() {
    if(userLoggedIn){
        setUpSliders();
        getTweets();
        getFollowers();
        syncFollowers();
    }
});

function setUpSliders(){
    tweetSlider = $('.tweet-slider').bxSlider({
        minSlides: 1,
        maxSlides: 3,
        slideWidth: 360,
        slideMargin: 10,
        pager: false,
        adaptiveHeight: true,
        auto: true
    });
    followerSlider = $('.followers-slider').bxSlider({
        minSlides: 3,
        maxSlides: 10,
        slideWidth: 200,
        slideMargin: 10,
        pager: false,
        adaptiveHeight: true,
        auto: true
    });
}

function getTweets(){
    $.ajax({
        url:"/getTweets.php",
        method:"GET",
        dataType:"json",
        success:function(response){
            if(response.status != 1){
                alert("Error Loading Tweets");
                return;
            }

            response.tweets.forEach(function(item,index){
                var tweetLi = $("<li/>");
                tweetLi.html(item);
                $("ul.tweet-slider").append(tweetLi);
            });

            tweetSlider.reloadSlider();
            $(".tweets > .loader").hide();
        }
    });
}

function getFollowers(){
    $.ajax({
        url:"/getFollower.php",
        method:"GET",
        dataType:"json",
        success:function(response){
            if(response.status != 1){
                alert("Error Loading Tweets");
                return;
            }

            response.followers.forEach(function(follower,index){
                var followLi = $("<li/>");
                var followA = $("<a/>").attr("href", "https://twitter.com/" + follower.screen_name);
                var followImg = $("<img/>").attr("src",follower.profile_image_url_https.replace('_normal',''));
                var followDiv = $("<div/>").addClass("caption");
                followDiv.html(follower.name);
                followA.append(followImg);
                followImg.addClass("img-responsive").addClass("image");
                followA.append(followDiv);
                followLi.append(followA);
                $("ul.followers-slider").append(followLi);
               
            });

            followerSlider.reloadSlider();
        }
    });
}

function syncFollowers(){
    $.ajax({
        url:"/syncFollowers.php",
        method:"GET",
        dataType:"json",
        success:function(response){

        }
    });
}

$(document).on('click', 'button.btn-twitter-login', function(event){
    event.preventDefault();
    var twitter_login_window = window.open(
        $(this).data('href'),
        "_blank",
        "toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=730, height=600"
    );

    twitter_login_window.onClose = function(){
        checkTwitterLogin();
    }
});

$(document).on('click', 'a.twitter-user-logout', function(event){
    event.preventDefault();
    logoutUser(true);
});

function checkTwitterLogin(twitterWindow){
    twitterWindow.close();
    $.ajax({
        url:"/checkLogin.php",
        method:"GET",
        dataType:"json",
        success:function(response){
            if(response.status != 1){
                logoutUser();
                return;
            }

            loginUser(response.user);
        }
    });
}

function logoutUser(doAjax){
    $("button.btn-twitter-login").prop("disabled", true);
    if(doAjax){ //User clicked on Logout
        $.ajax({
            url:"/logout.php",
            method:"GET",
            dataType:"json",
            success:function(response){
                if(response.status != 1){                    
                    return;
                }

                $("button.btn-twitter-login").attr("data-href", response.url);
                $("button.btn-twitter-login").prop("disabled", false);
            }
        });
    }else{ //CheckLogin Function found no user logged in
        setNewTwitterLoginURL();
    }

    $('span.navbar-twitter-user-name').html("Twitter User");
    $('a.navbar-twitter-user-url').attr("href", "#");
    $('img.navbar-twitter-user-profile').attr("src","#");
    $('div.navbar-guest-user').show();
    $('div.navbar-twitter-user').hide();

    $('div.panel.panel-default').hide();
    $('div.panel.panel-default.twitter-login').show();

    userLoggedIn = false;
}

function setNewTwitterLoginURL(){
    $.ajax({
        url:"/getTwitterLoginURL.php",
        method:"GET",
        dataType:"json",
        success:function(response){
            if(response.status != 1){
                logoutUser();
                return;
            }

            $("button.btn-twitter-login").attr("data-href", response.url);
            $("button.btn-twitter-login").prop("disabled", false);
        }
    });
}

function loginUser(user){
    $('span.navbar-twitter-user-name').html(user.name);
    $('img.navbar-twitter-user-profile').attr("src",user.profile_image_url_https);
    $('a.navbar-twitter-user-url').attr("href", "https://twitter.com/" + user.screen_name);
    $('div.navbar-guest-user').hide();
    $('div.navbar-twitter-user').show();

    $('div.panel.panel-default').show();
    $('div.panel.panel-default.twitter-login').hide();
    userLoggedIn = true;

    setUpSliders();
    getTweets();
    getFollowers();
    syncFollowers();

    $("button.btn-twitter-login").attr("data-href", "#");
}
 $( ".followers-search" ).autocomplete({
    source: function( request, response ) {
        $.ajax({
            url: "/searchFollowers.php",
            dataType: "json",
            data: {
                query: request.term
            },
            success: function( data ) {
                response($.map(data.followers, function(follower, index){
                    return {
                        label: follower.name,
                        follower: follower,
                    };
                }));
            }
        });
    },
    minLength: 0,
    select: function( event, ui ) {
        updateFollowerModalInfo(ui.item.follower);
        $(".modal.follower-info").modal('show');
    },
});

function updateFollowerModalInfo(follower){
    $(".followers-search-img").attr("src",follower.profile_image_url_https.replace('_normal',''));
    $(".followers-search-name").html(follower.name);
    $(".followers-search-location").html(follower.location);
    $(".followers-search-screen_name").html("@"+follower.screen_name);
    $(".followers-search-tweets").html(follower.statuses_count);
    $(".followers-search-following").html(follower.friends_count);
    $(".followers-search-followers").html(follower.followers_count);
    $(".followers-search-likes").html(follower.favourites_count);
    $(".follower-profile-links").attr("href", "https://twitter.com/" + follower.screen_name);
    $(".following-links").attr("href", "https://twitter.com/" + follower.screen_name + "/following");
    $(".followers-links").attr("href", "https://twitter.com/" + follower.screen_name + "/followers");
    $(".likes-links").attr("href", "https://twitter.com/" + follower.screen_name + "/likes");




}

$(document).on('click', '.user-profile', function(event){
    $.ajax({
        url:"/userDetail.php",
        dataType:"json",
        method:"GET",
         success:function(response){
            if(response.status != 1){
                alert("Error Loading Tweets");
                return;
            }

            updateProfileModalInfo(response.userdetail);
             $(".modal.follower-info").modal('show');
          }   
    })
});
 function updateProfileModalInfo(myprofile){
    $(".followers-search-img").attr("src",myprofile.profile_image_url_https.replace('_normal',''));
    $(".followers-search-name").html(myprofile.name);
    $(".followers-search-location").html(myprofile.location);
    $(".followers-search-screen_name").html("@"+myprofile.screen_name);
    $(".followers-search-tweets").html(myprofile.statuses_count);
    $(".followers-search-following").html(myprofile.friends_count);
    $(".followers-search-followers").html(myprofile.followers_count);
    $(".followers-search-likes").html(myprofile.favourites_count);
    $(".follower-profile-links").attr("href", "https://twitter.com/" + myprofile.screen_name);
    $(".following-links").attr("href", "https://twitter.com/" + myprofile.screen_name + "/following");
    $(".followers-links").attr("href", "https://twitter.com/" + myprofile.screen_name + "/followers");
    $(".likes-links").attr("href", "https://twitter.com/" + myprofile.screen_name + "/likes");
 }
