<?php
    session_start();
    require_once("twitteroauth/twitteroauth.php");
    
    $to = new TwitterOAuth("GM9kDsMldiww849iY9CegA","hMOe5UjKjzM4D6rHQf5S8M7VeubGc3j7OGDwNEWIo",$_SESSION["oauth_token"],$_SESSION["oauth_token_secret"]);
    $verifier = $to->getAccessToken($_REQUEST["oauth_verifier"]);
    
    $_SESSION["access_token"] = $verifier["oauth_token"];
    $_SESSION["access_token_secret"] = $verifier["oauth_token_secret"];
    $_SESSION["user_id"] = $verifier["user_id"];
    $_SESSION["screen_name"] = $verifier["screen_name"];
    header("Location: if.php");