<?php
    session_start();
    require("../database_connect.php");
    require("../functions.php");
    
    if(!isset($_SESSION["username"]))
    {
        header("Location: error.html");
        exit;
    }
    if(!empty($_POST))
    {
        
            if(!check_screen_name($_POST["password"])) { $error["password"]["etc"] = "etc"; }
            if($_POST["password"] == "") { $error["password"]["length"] = "error"; }
        
            if(empty($error))
            {
                $id_s = 'SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($_SESSION["username"]).'";';
                $id_res = mysql_query($id_s);
                $id_fetched = mysql_fetch_assoc($id_res);
                $uid = $id_fetched["id"];
                
                $sq1 = 'SELECT * FROM member_info WHERE screen_name="'.mysql_real_escape_string($_SESSION["username"]).'" AND password="'.sha1(mysql_real_escape_string($_POST["password"])).'";';
            
                $re = mysql_query($sq1) or die(mysql_error());
                if($data = mysql_fetch_assoc($re))
                {
                    if($data["screen_name"] == $_SESSION["username"])
                    {
                        $l1 = 'UPDATE links SET linktitle="'.mysql_real_escape_string($_SESSION["settings_link"]["link1_title"]).'",linkURL="'.mysql_real_escape_string($_SESSION["settings_link"]["link_1"]).'" WHERE id="'.$uid.'" AND linkid="l1";';
                        $l2 = 'UPDATE links SET linktitle="'.mysql_real_escape_string($_SESSION["settings_link"]["link2_title"]).'",linkURL="'.mysql_real_escape_string($_SESSION["settings_link"]["link_2"]).'" WHERE id="'.$uid.'" AND linkid="l2";';
                        $l3 = 'UPDATE links SET linktitle="'.mysql_real_escape_string($_SESSION["settings_link"]["link3_title"]).'",linkURL="'.mysql_real_escape_string($_SESSION["settings_link"]["link_3"]).'" WHERE id="'.$uid.'" AND linkid="l3";';
                        $l4 = 'UPDATE links SET linktitle="'.mysql_real_escape_string($_SESSION["settings_link"]["link4_title"]).'",linkURL="'.mysql_real_escape_string($_SESSION["settings_link"]["link_4"]).'" WHERE id="'.$uid.'" AND linkid="l4";';
                        
                        $webservices = 'UPDATE webservice SET delicious="'.mysql_real_escape_string($_SESSION["settings_link"]["delicious"]).'",deviantart="'.mysql_real_escape_string($_SESSION["settings_link"]["deviantart"]).'",facebook="'.mysql_real_escape_string($_SESSION["settings_link"]["facebook"]).'",flickr="'.mysql_real_escape_string($_SESSION["settings_link"]["flickr"]).'",lastfm="'.mysql_real_escape_string($_SESSION["settings_link"]["lastfm"]).'",linkdin="'.mysql_real_escape_string($_SESSION["settings_link"]["linkdin"]).'",myspace="'.mysql_real_escape_string($_SESSION["settings_link"]["myspace"]).'",psn="'.mysql_real_escape_string($_SESSION["settings_link"]["psn"]).'",tumblr="'.mysql_real_escape_string($_SESSION["settings_link"]["tumblr"]).'",twitter="'.mysql_real_escape_string($_SESSION["settings_link"]["twitter_id"]).'",youtube="'.mysql_real_escape_string($_SESSION["settings_link"]["youtube"]).'",amazon="'.mysql_real_escape_string($_SESSION["settings_link"]["amazon"]).'",github="'.mysql_real_escape_string($_SESSION["settings_link"]["github"]).'",mail="'.mysql_real_escape_string($_SESSION["settings_link"]["email"]).'",skype="'.mysql_real_escape_string($_SESSION["settings_link"]["skype"]).'",picasa="'.mysql_real_escape_string($_SESSION["settings_link"]["picasa"]).'" WHERE id="'.mysql_real_escape_string($uid).'";';
                        
                        mysql_query($l1);
                        mysql_query($l2);
                        mysql_query($l3);
                        mysql_query($l4);
                        mysql_query($webservices) or die(mysql_error());
                        
                        $user_id = "http://verbindung.me/profile.php?id=".$_SESSION["username"];
                        header("Location: ".$user_id);
                    }
                }
                else
                {
                    $error["login"] = "failed";
                }
            }
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Verbindung+</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
            <div id="continer">
            <span id="head">
            <br>
            <img src="../images/header.png">
            <p><strong>あなただけの公開プロフィールを簡単に作成、共有する</strong></p>
            <div id="content">
                <div id="content_inner">
                    <span id="mi"><strong>認証</strong></span><br>
                    <span id="inner">
                        編集した情報を反映させます。<br>
                        セキュリティチェックのためにあなたのアカウントのパスワードを入力しボタンを押してください。<br>
                        パスワードが正しければ、編集した情報があなたのVerbindung+アカウント情報として登録されます。<br>
                        <form class="submit_form" action="" method="POST"><br>
                        <input type="hidden" name="action" value="submit">
                                                    <p id="description_background"><br>
                                    　　　　　　　<input type="password" name="password" placeholder="あなたのパスワードを入力..." class="text"><br>
                                    　　　　　　　<?php if($error["password"]["etc"] == "etc"): ?>
                                    　　　　　　　     <font size="3" color="red">*パスワードには日本語や記号は入力できません。</font><br>
                                    　　　　　　　<?php endif; ?>
                                    　　　　　　　<?php if($error["password"]["length"] == "error"): ?>
                                    　　　　　　　     <font size="3" color="red">*パスワードを入力してください。</font><br>
                                    　　　　　　　 <?php endif; ?>
                                    　　　　　　　<?php if($error["login"] == "failed"): ?>
                                    　　　　　　　     <font size="3" color="red">*ログインに失敗しました。</font><br>
                                    　　　　　　　<?php endif; ?>
                                </p>
                                <br>
                                <a href="../settings.php" class="super button blue">　<< 戻る(トップへ)　</a> 
                                <input type="submit" class="super button pink" value="　>> 内容を反映させる　" style="border:0;">
                        </form>
                    </span>
                </div>
            </div>
    </body>
</html>