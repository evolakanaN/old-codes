<?php
    session_start();
    require("database_connect.php");
    require("functions.php");
    
    if(!isset($_SESSION["join"]))
    {
       header("Location: error.html");
    }
    if(!empty($_POST))
    {
        $sq1 = 'INSERT INTO member_info SET screen_name="'.mysql_real_escape_string($_SESSION["join"]["screen_name"]).'",display_name="'.mysql_real_escape_string($_SESSION["join"]["display_name"]).'",password="'.sha1(mysql_real_escape_string($_SESSION["join"]["password"])).'";';
                
        mysql_query($sq1) or die(mysql_error());
        
        $sq4 = 'SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($_SESSION["join"]["screen_name"]).'";';
        $sq4_res = mysql_query($sq4) or die(mysql_error());
        $fetched = mysql_fetch_assoc($sq4_res);
        $uid = $fetched["id"];
        $sq3 = 'INSERT INTO member_profile SET id="'.$uid.'",profile_image="default.png",location=NULL,works=NULL,comment=NULL';
        mysql_query($sq3) or die(mysql_error());
        $sq4 = 'INSERT INTO vote SET screen_name="'.mysql_real_escape_string($_SESSION["join"]["screen_name"]).'",vote_count=0';
        mysql_query($sq4) or die(mysql_error());
        
        mysql_query('INSERT INTO user_tags SET tagid="c1",tag="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO user_tags SET tagid="c2",tag="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO user_tags SET tagid="c3",tag="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO user_tags SET tagid="c4",tag="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO user_tags SET tagid="c5",tag="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO user_tags SET tagid="c6",tag="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        
        mysql_query('INSERT INTO links SET linkid="l1",linktitle="",linkURL="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO links SET linkid="l2",linktitle="",linkURL="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO links SET linkid="l3",linktitle="",linkURL="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO links SET linkid="l4",linktitle="",linkURL="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        
        mysql_query('INSERT INTO webservice SET id="'.mysql_real_escape_string($uid).'",delicious=NULL,deviantart=NULL,facebook=NULL,flickr=NULL,lastfm=NULL,linkdin=NULL,myspace=NULL,psn=NULL,tumblr=NULL,twitter=NULL,youtube=NULL,amazon=NULL,github=NULL,mail=NULL,skype=NULL,picasa=NULL,gmail=NULL;') or die(mysql_error());
        
        mysql_query('INSERT INTO other_user_tags SET tagid="c1",tag="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO other_user_tags SET tagid="c2",tag="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO other_user_tags SET tagid="c3",tag="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO other_user_tags SET tagid="c4",tag="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO other_user_tags SET tagid="c5",tag="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        mysql_query('INSERT INTO other_user_tags SET tagid="c6",tag="",id="'.mysql_real_escape_string($uid).'";') or die(mysql_error());
        
        unset($_SESSION["join"]);
        header('Location: thanks.html');
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Verbindung+</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
            <div id="continer">
            <span id="head">
            <br>
            <img src="images/header.png">
            <p><strong>あなただけの公開プロフィールを簡単に作成、共有する</strong></p>
            <div id="content">
                <div id="content_inner">
                    <span id="mi"><strong>確認</strong></span><br>
                    <span id="inner">
                        登録の確認をします!下に表示されている内容でよければ、登録ボタンを押してください。<br>
                        登録ボタンをクリックすると、Verbindung+アカウントが作成されます。<br>
                        また、これ以降IDの変更はできませんのでご注意ください。(表示名はいつでも変更することができます)<br>
                        <form class="submit_form" action="" method="POST"><br>
                        <input type="hidden" name="action" value="submit">
                                                    <p id="description_background">
                                <strong>[1]ユーザーID: </strong> <?php print(htmlspecialchars($_SESSION["join"]["screen_name"],ENT_QUOTES,"UTF-8")); ?><br></dd></strong>
                                <strong>[2]表示名: </strong> <?php print(htmlspecialchars($_SESSION["join"]["display_name"],ENT_QUOTES,"UTF-8")); ?><br>
                                <strong>[3]パスワード: </strong>セキュリティのために非表示です<br>
                                </p>
                                <br>
                                <a href="index.html" class="super button blue">　<< 戻る(トップへ)　</a> 
                                <input type="submit" class="super button pink" value="　>> 進む(完了)　" style="border:0;">
                        </form>
                    </span>
                </div>
            </div>
    </body>
</html>