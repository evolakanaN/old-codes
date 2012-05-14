<?php
    session_start();
    require("twitteroauth/twitteroauth.php");
    
    $to = new TwitterOAuth("GM9kDsMldiww849iY9CegA","hMOe5UjKjzM4D6rHQf5S8M7VeubGc3j7OGDwNEWIo");
    $request_token = $to->getRequestToken();
    
    $_SESSION["oauth_token"] = $token = $request_token["oauth_token"];
    $_SESSION["oauth_token_secret"] = $request_token["oauth_token_secret"];
    $jump_u = $to->getAuthorizeURL($token);
   header("Location: ".$jump_u);