
    $s1 = mysql_fetch_assoc(mysql_query('SELECT * FROM member_info WHERE uid="'.mysql_real_escape_string($uid).'";'));
    
    $access_token = $s1["access_token"];
    $access_token_s = $s1["access_token_secret"];
    
    $api = new ux_nu();
    $post = $c." - ".$title.": ".$api->shorten($url)." #schwarz";
    $to = new TwitterOAuth("GM9kDsMldiww849iY9CegA","hMOe5UjKjzM4D6rHQf5S8M7VeubGc3j7OGDwNEWIo",$access_token,$access_token_s);
    $to->OAuthRequest("http://api.twitter.com/1/statuses/update.xml","POST",array("status"=>$post));
    
    $s2 = mysql_query('INSERT INTO member_status SET member_id="'.mysql_real_escape_string($s1["id"]).'",title="'.mysql_real_escape_string($title).'",comment="'.mysql_real_escape_string($c).'",site_url="'.mysql_real_escape_string($url).'",rate="'.mysql_real_escape_string($rate).'";') or die(mysql_error());
    
    $s3 = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS xt FROM site_directory WHERE title="'.mysql_real_escape_string($title).'" AND site_url="'.mysql_real_escape_string($url).'";'));
    
    if($s3["xt"] == 0 || $s3["xt"] == "0")
    {
        $parsed_url = parse_url($url);
        $type = 1;
        if(preg_match("/youtube\.com/",$parsed_url["host"]) || preg_match("/vimeo\.com/",$parsed_url["host"]) || preg_match("/dailymotion\.com/",$parsed_url["host"]))
        {
            $type_s = 2;
        }
        if(preg_match("/twitpic\.com/",$parsed_url["host"]) || preg_match("/yfrog\.com/",$parsed_url["host"]))
        {
            $type_s = 3;
        }
        $s4 = mysql_query('INSERT INTO site_directory SET title="'.mysql_real_escape_string($title).'",site_url="'.mysql_real_escape_string($url).'",type="'.mysql_real_escape_string($type_s).'";');
        
        $ret = '';
        $ret .= '<strong>投稿完了</strong>';
        $ret .= '<br>';
        $ret .= '<p style="width:460px;height:1px;background-color:#ffffff;opacity:0.5;"></p>';
        $ret .= '<p style="opacity:0.8;font-size:13;">';
        $ret .= 'TwitterとSchwarzへサイト情報を投稿しました。';
        $ret .= '</p>';
        $ret .= '<script>setTimeout(function(){window.close();},600);</script>';
        print($ret);
    }
        $ret = '';
        $ret .= '<strong>投稿完了</strong>';
        $ret .= '<br>';
        $ret .= '<p style="width:460px;height:1px;background-color:#ffffff;opacity:0.5;"></p>';
        $ret .= '<p style="opacity:0.8;font-size:13;">';
        $ret .= 'TwitterとSchwarzへサイト情報を投稿しました。';
        $ret .= '</p>';
        $ret .= '<script>setTimeout(function(){window.close();},600);</script>';
        print($ret);