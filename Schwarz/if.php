<?php
    session_start();
    require("database_connect.php");
    require("twitteroauth/twitteroauth.php");
    
    $to = new TwitterOAuth("GM9kDsMldiww849iY9CegA","hMOe5UjKjzM4D6rHQf5S8M7VeubGc3j7OGDwNEWIo",$_SESSION["access_token"],$_SESSION["access_token_secret"]);
    $to->format = "xml";
    $sql = mysql_fetch_assoc(mysql_query('SELECT COUNT(id) AS xt FROM member_info WHERE id="'.mysql_real_escape_string($_SESSION["user_id"]).'";'));
    
    $res = $to->OAuthRequest("https://api.twitter.com/1/users/show.xml","GET",array("user_id"=>$_SESSION["user_id"]));
    $xml = simplexml_load_string($res);
    
    $nn = mysql_fetch_assoc(mysql_query('SELECT COUNT(id) AS nt FROM profile_image WHERE id="'.mysql_real_escape_string($_SESSION["user_id"]).'";'));
    if($sql["xt"] > 0) {
        if($nn["nt"] == 0) {
            mysql_query('INSERT INTO profile_image SET id="'.mysql_real_escape_string($_SESSION["user_id"]).'",profile_image_url="'.mysql_real_escape_string($xml->profile_image_url).'";');
        }
        mysql_query('UPDATE profile_image SET profile_image_url="'.mysql_real_escape_string($xml->profile_image_url).'" WHERE id="'.mysql_real_escape_string($_SESSION["user_id"]).'";');
        $h_url = "http://verbindung.me/schwarz/user.php?id=".$_SESSION["user_id"];
        header("Location: ".$h_url);
    } else {
        
        $s1 = 'INSERT INTO member_info SET id="'.mysql_real_escape_string($_SESSION["user_id"]).'",screen_name="'.mysql_real_escape_string($_SESSION["screen_name"]).'",access_token="'.mysql_real_escape_string($_SESSION["access_token"]).'",access_token_secret="'.mysql_real_escape_string($_SESSION["access_token_secret"]).'";';
        mysql_query($s1) or die(mysql_error());
        
        $s2 = mysql_fetch_assoc(mysql_query('SELECT * FROM member_info WHERE id="'.mysql_real_escape_string($_SESSION["user_id"]).'";'));
        $uid = sha1($s2["id"])."-".sha1(session_id())."-".sha1($s2["timestamp"]);
        mysql_query('UPDATE member_info SET uid="'.mysql_real_escape_string($uid).'" WHERE id="'.mysql_real_escape_string($s2["id"]).'";') or die(mysql_error());
        mysql_query('INSERT INTO settings SET id="'.mysql_real_escape_string($s2["id"]).'",data_sharing="1",sync_post="1",trans_url="1";') or die(mysql_error());
        
        mysql_query('INSERT INTO profile_image SET id="'.mysql_real_escape_string($_SESSION["user_id"]).'",profile_image_url="'.mysql_real_escape_string($xml->profile_image_url).'";');
        
        $_SESSION["username"] = $s2["id"];
        
        header("Location: http://verbindung.me/schwarz/wizard/2.php");
    }
