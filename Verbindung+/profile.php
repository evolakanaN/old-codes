<?php
    session_start();
    require("database_connect.php");
        $un = mysql_query('SELECT COUNT(*) AS n FROM member_info WHERE screen_name="'.mysql_real_escape_string(htmlspecialchars($_GET["id"],ENT_QUOTES)).'";');
        $un_r = mysql_fetch_assoc($un);
        
        $sql = 'SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string(htmlspecialchars($_GET["id"],ENT_QUOTES)).'";';
        $result = mysql_query($sql) or die(mysql_error());
        $fetched = mysql_fetch_assoc($result);
        $uid = $fetched["id"];
        if($un_r["n"] == 0)
        {
            header("Location: http://verbindung.me/error.html");
            exit;
        }
        $member_info = 'SELECT * FROM member_info WHERE id="'.mysql_real_escape_string($uid).'";';
        $vote = 'SELECT vote_count FROM vote WHERE screen_name="'.mysql_real_escape_string(htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8")).'";';
        $member_profile = 'SELECT * FROM member_profile WHERE id="'.mysql_real_escape_string($uid).'";';
        $link = 'SELECT * FROM links WHERE id="'.mysql_real_escape_string($uid).'";';
        $webservice = 'SELECT * FROM webservice WHERE id="'.mysql_real_escape_string($uid).'";';
        
        $member_info_d = mysql_query($member_info);
        $vote_d = mysql_query($vote);
        $member_profile_d = mysql_query($member_profile) or die(mysql_error());
        $link_d = mysql_query($link);
        $webservice_d = mysql_query($webservice);
                
        $member_i = mysql_fetch_assoc($member_info_d);
        $vote_i = mysql_fetch_assoc($vote_d);
        $member_profile_i = mysql_fetch_assoc($member_profile_d);
        $link_i = mysql_fetch_assoc($link_d);
        $webservice_i = mysql_fetch_assoc($webservice_d);
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="http://verbindung.me/css/style.css">
        <script type="text/javascript" src="http://verbindung.me/profile.js"></script>
        <title>Verbindung+<?php print(htmlspecialchars($member_i["display_name"],ENT_QUOTES,"UTF-8")); ?></title>
    </head>
    <body>
        <div id="continer">
            <span id="head">
                <br>
                <h1><a href="http://verbindung.me/"><img src="http://verbindung.me/images/header.png"></a></h1>
                <span id="btn_c">
                    <span id="signup_or_login">
                        <?php if($_SESSION["username"] == htmlspecialchars($_GET["id"],ENT_QUOTES)): ?>
                            <a href='http://verbindung.me/settings.php' class='medium button green'>　+設定/ログアウト　</a>
                        <?php endif; ?>
                        <?php if(!isset($_SESSION["username"])): ?>
                            <a href='http://verbindung.me/login.php' class='medium button green'>　+ログイン　</a>
                        <?php endif; ?>
                        <?php if(isset($_SESSION["username"]) && $_SESSION["username"] != htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8")):?>
                            <a href='<?php print("http://verbindung.me/id/".htmlspecialchars($_SESSION["username"],ENT_QUOTES,"UTF-8")); ?>' class="medium button green">　+自分のプロフィールへ　</a>
                        <?php endif; ?>
                    </span>
                </span>
                <p><strong>あなただけの公開プロフィールを簡単に作成、共有する。</strong></p>
            </span>
            <div id="content">
                <div id="content_inner">
                    <span id="koko"></span>
                    <span id="inner">
                        
                            <img src="<?php print('http://img.verbindung.me/'.htmlspecialchars($member_profile_i['profile_image'],ENT_QUOTES,'UTF-8')); ?>" class="imgleft" id="img_frame" width="128" height="128">
                            <p class="ma" id="description_background">
                            <font size="5"><?php if(is_null($member_i["display_name"])){print("あばばばば");}else{print(htmlspecialchars($member_i["display_name"],ENT_QUOTES,"UTF-8"));} ?></font><br>
                            <img src="http://verbindung.me/images/home.png" width="16" height="16"><strong>居住地: </strong> <?php if(is_null($member_profile_i["location"])){print("入力されていません");}else{print(htmlspecialchars($member_profile_i["location"],ENT_QUOTES,"UTF-8"));} ?> <br>
                            <img src="http://verbindung.me/images/work.png" width="16" height="16"><strong>勤務先: </strong> <?php if(is_null($member_profile_i["works"])){print("入力されていません");}else{print(htmlspecialchars($member_profile_i["works"],ENT_QUOTES,"UTF-8"));} ?>
                            
                            <br>
                            <img src="http://verbindung.me/images/cluster.png" width="16" height="16"><strong>クラスタ: </strong>
                            <?php
                                $sq_t = 'SELECT tag FROM user_tags WHERE id="'.mysql_real_escape_string($uid).'";';
                                $sq_res = mysql_query($sq_t) or die(mysql_error());
                                
                                while($d_r = mysql_fetch_assoc($sq_res))
                                {
                                    $hht = '<a href="http://verbindung.me/search.php?tag='.urlencode(htmlspecialchars($d_r["tag"],ENT_QUOTES,"UTF-8")).'">'.htmlspecialchars($d_r["tag"],ENT_QUOTES,"UTF-8").'</a>　';
                                    print($hht);
                                }
                            ?>
                            <br>
                            <img src="http://verbindung.me/images/description.png" width="16" height="16"><strong>一言コメント: </strong> <?php if(is_null($member_profile_i["comment"])){print("入力されていません");}else{print(htmlspecialchars($member_profile_i["comment"],ENT_QUOTES,"UTF-8"));} ?> <br>
                            </p>
                            <input type="button" class="medium button pink" value="　この人に対して拍手を送る　" style="border:0;" id="vote_in" onClick="vote('count');">
                            <input type="button" id="vote_r" class="medium button blue" value="<?php if($vote_i['vote_count'] == 0){print('　この人に対して拍手している人はまだいません　');}else{print('　'.$vote_i['vote_count'].' 人がこの人に対して拍手しています　');} ?>" style="border:0;"> <input type="button" class="medium button dblue" value="　他人からの評価(α)　" onClick="location.href='http://verbindung.me/friend/friend.php?id='+document.getElementById('user_id').value;" style="border:0;">
                            <input type="hidden" id="user_id" name="user_id" value="<?php print(htmlspecialchars($member_i['screen_name'],ENT_QUOTES,'UTF-8')); ?>">
                    </span><br>
                        <span id="koko"></span>
                        <span id="inner">
                                <br><br>
                                <?php
                                    $sq8 = 'SELECT * FROM webservice WHERE id="'.mysql_real_escape_string($uid).'";';
                                    $res_8 = mysql_query($sq8) or die(mysql_error());
                                    $r8 = mysql_fetch_assoc($res_8);
                                    
                                    $output = "";
                                    if($r8["delicious"] != NULL) {$output .= '<a href="http://www.delicious.com/'.htmlspecialchars($r8["delicious"],ENT_QUOTES,"UTF-8").'"><img src="http://verbindung.me/images/delicious.png"></a>　'; }
                                    if($r8["deviantart"] != NULL){ $output .= '<a href="'.htmlspecialchars($r8["deviantart"],ENT_QUOTES,"UTF-8").'"><img src="http://verbindung.me/images/deviantart.png"></a>　'; }
                                    if($r8["twitter"] != NULL) { $output .='<a href="http://twitter.com/'.htmlspecialchars($r8["twitter"],ENT_QUOTES,"UTF-8").'/"><img src="http://verbindung.me/images/twitter.png"></a>　'; }
                                    if($r8["facebook"] != NULL) { $output .= '<a href="'.htmlspecialchars($r8["facebook"],ENT_QUOTES,"UTF-8").'"><img src="http://verbindung.me/images/facebook.png"></a>　'; }
                                    if($r8["flickr"] != NULL) { $output .= '<a href="'.htmlspecialchars($r8["flickr"],ENT_QUOTES,"UTF-8").'/"><img src="http://verbindung.me/images/flickr.png"></a>　'; }
                                    if($r8["lastfm"] != NULL) { $output .= '<a href="http://last.fm/user/'.htmlspecialchars($r8["lastfm"],ENT_QUOTES,"UTF-8").'"><img src="http://verbindung.me/images/lastfm.png"></a>　'; }
                                    if($r8["linkdin"] != NULL) { $output .= '<a href="'.htmlspecialchars($r8["linkdin"],ENT_QUOTES,"UTF-8").'"><img src="http://verbindung.me/images/linkdin.png"></a>　'; }
                                    if($r8["myspace"] != NULL) { $output .= '<a href="'.htmlspecialchars($r8["myspace"],ENT_QUOTES,"UTF-8").'"><img src="http://verbindung.me/images/myspace.png"></a>　'; }
                                    if($r8["psn"] != NULL) { $output .= '<img src="http://verbindung.me/images/playstation.png" title="PSN ID:'.htmlspecialchars($r8["psn"],ENT_QUOTES,"UTF-8").'" class="hv">　'; }
                                    if($r8["tumblr"] !=NULL) { $output .= '<a href="'.htmlspecialchars($r8["tumblr"],ENT_QUOTES,"UTF-8").'"><img src="http://verbindung.me/images/tumblr.png"></a>　'; }
                                    if($r8["youtube"] !=NULL) { $output .= '<a href="http://www.youtube.com/user/'.htmlspecialchars($r8["youtube"]).'"><img src="http://verbindung.me/images/youtube.png"></a>　'; }
                                    if($r8["amazon"] != NULL) { $output .= '<a href="'.htmlspecialchars($r8["amazon"],ENT_QUOTES,"UTF-8").'"><img src="http://verbindung.me/images/amazon.png"></a>　'; }
                                    if($r8["github"] != NULL) { $output .= '<a href="http://github.com/'.htmlspecialchars($r8["github"],ENT_QUOTES,"UTF-8").'"><img src="http://verbindung.me/images/github.png"></a>　'; }
                                    if($r8["mail"] != NULL) { $output .='<a href="mailto:'.htmlspecialchars($r8["mail"],ENT_QUOTES,"UTF-8").'"><img src="http://verbindung.me/images/email.png"></a>　'; }
                                    if($r8["skype"] != NULL) { $output .='<a href="skype:'.htmlspecialchars($r8["skype"],ENT_QUOTES,"UTF-8").'?chat"><img src="http://verbindung.me/images/skype.png" title="Skype ID:'.htmlspecialchars($r8["skype"],ENT_QUOTES,"UTF-8").'" class="hv"></a>　'; }
                                    if($r8["picasa"] != NULL) { $output.='<a href="'.htmlspecialchars($r8["picasa"],ENT_QUOTES,"UTF-8").'"><img src="http://verbindung.me/images/picasa.png"></a>　'; }
                                    
                                    print($output);
                                ?>
                            
                        </span>
                        <span id="koko"></span><br>
                        <span id="inner">
                                <br><br>
                                <?php
                                    $sq2 = 'SELECT linkid,linktitle,linkURL FROM links WHERE id="'.mysql_real_escape_string($uid).'";';
                                    $res = mysql_query($sq2) or die(mysql_error());
                                    
                                    while($data_r = mysql_fetch_assoc($res))
                                    {
                                        
                                        if($data_r["linkid"] != "" && $data_r["linktitle"] != "" && $data_r["linkURL"] != "")
                                        {
                                        $h_tag = '<img src="http://verbindung.me/images/12.png" width="16" height="16"> '.htmlspecialchars($data_r["linktitle"],ENT_QUOTES,"UTF-8").' - <a href="'.htmlspecialchars($data_r["linkURL"],ENT_QUOTES,"UTF-8").'">'.htmlspecialchars($data_r["linkURL"],ENT_QUOTES,"UTF-8").'</a><br>';
                                        print($h_tag);
                                       
                                       }
                                       else
                                       {
                                        print("");
                                       }
                                    }
                                ?>
                        </span>
                </div>
            </div>
        </div>
    </body>
</html>