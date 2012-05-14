<?php
    require("../lib/ux_nu.php");
    require("../database_connect.php");
    require_once("../twitteroauth/twitteroauth.php");

    $title = urldecode(htmlspecialchars($_POST["title"]));
    $url   = urldecode($_POST["url"]);
    $uid   = htmlspecialchars($_POST["uid"]);
    $c     = urldecode(htmlspecialchars($_POST["comment"]));
    $rate = "";
    
    if($title == "") {
        $title = $url;
    }
    
    function return_r($_cap){
    $_ts = "";
    $_exp = explode("]",$_cap);
    for($_i=0; $_i<count($_exp); $_i++){
        $_ts .= str_replace("[","",$_exp[$_i]).",";
    }
    $_ret = explode(",",$_ts);
    for($_j=0; $_j<count($_ret); $_j++) {
        if($_ret[$_j] == "" || $_ret[$_j] == NULL) {
            array_splice($_ret,$_j);
        }
    }
    return array_unique($_ret);
    }    
    $s1 = mysql_fetch_assoc(mysql_query('SELECT * FROM member_info WHERE uid="'.mysql_real_escape_string($uid).'";'));
    
    $access_token = $s1["access_token"];
    $access_token_s = $s1["access_token_secret"];
    
    $api = new ux_nu();
    $post = "";
    if($c != "") {
        $post = $c." - ".mb_strimwidth($title,0,100,"...",utf8).": ".$api->shorten($url)." #schwarz_b";
    } else {
        $post =  mb_strimwidth($title,0,100,"...",utf8).": ".$api->shorten($url)." #schwarz_b";
    }
    if(preg_match("/\[.*\]/",$c,$cap)) {
            $tg = return_r($cap[0]);
            for($i=0; $i<count($tg); $i++) {
                mysql_query('INSERT INTO status_tag SET created_at=NOW(),site_url="'.mysql_real_escape_string($url).'",tag="'.mysql_real_escape_string($tg[$i]).'",member_id="'.mysql_real_escape_string($s1["id"]).'";');       
            }
    }
    $to = new TwitterOAuth("GM9kDsMldiww849iY9CegA","hMOe5UjKjzM4D6rHQf5S8M7VeubGc3j7OGDwNEWIo",$access_token,$access_token_s);
    $to->OAuthRequest("http://api.twitter.com/1/statuses/update.xml","POST",array("status"=>$post));
    $s2 = mysql_query('INSERT INTO member_status SET member_id="'.mysql_real_escape_string($s1["id"]).'",title="'.mysql_real_escape_string($title).'",comment="'.mysql_real_escape_string($c).'",site_url="'.mysql_real_escape_string($url).'",rate="'.mysql_real_escape_string($rate).'";') or die(mysql_error());
    
    $s3 = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS xt FROM site_directory WHERE title="'.mysql_real_escape_string($title).'" AND site_url="'.mysql_real_escape_string($url).'";'));
    print("ok");
    if($s3["xt"] == 0 || $s3["xt"] == "0"){
        $type = 0;
        if(preg_match("/youtube\.com\/watch/",$url) || preg_match("/www\.nicovideo\.jp\/watch\/\w+/",$url) ||  preg_match("/vimeo\.com\/\w+/",$url) || preg_match("/www.dailymotion\.com\/video/",$url)|| preg_match("/www.dailymotion\.com\/video/",$url) || preg_match("/http:\/\/www\.veoh\.com\/watch\/\w+/",$url) || preg_match("/http:\/\/www\.ustream\.tv\/recorded\/\d+/",$url) || preg_match("/http:\/\/www\.im\.tv\/vlog\/[pP]ersonal\/\d+\/\d+/",$url)){
            $type_s = 2;
        }
        if(preg_match("/twitpic\.com\/\w+/",$url) || preg_match("/yfrog\.com\/\w+/",$url) || preg_match("/http:\/\/lockerz\.com\/s\/\w+/",$url) || preg_match("/http:\/\/p\.twipple\.jp\/\w+/",$url) || preg_match("/http:\/\/www\.flickr\.com\/photos\/[\w-_@]+\/(\d+)/",$url) || preg_match("/http:\/\/pckles\.com\/[\w-_@]+\/\w+/",$url) || preg_match("/http:\/\/[^\s]*?\.(jpg|png|jpeg|gif)/",$url) || preg_match("/http:\/\/instagr\.am\/p\/\w+\//",$url) || preg_match("/http:\/\/photozou\.jp\/photo\/show\/\d+\/\d+/",$url)){
            $type_s = 3;
        }
        if(preg_match("/2ch\.net/",$url)) {
            $type_s = 4;
        }
        if(preg_match("/gist\.github\.com\/\d+/",$url)) {
            $type_s = 5;
        }
        $s4 = mysql_query('INSERT INTO site_directory SET title="'.mysql_real_escape_string($title).'",site_url="'.mysql_real_escape_string($url).'",type="'.mysql_real_escape_string($type_s).'";');
        print("ok");
    }