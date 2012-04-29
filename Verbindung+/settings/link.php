<?php
    session_start();
    require("../database_connect.php");
    require("../functions.php");
    
    if(!isset($_SESSION["username"]))
    {
        header("Location: http://verbindung.me/error.html");
        exit;
    }
    $s = 'SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($_SESSION["username"]).'"';
    $res = mysql_query($s) or die(mysql_error());
    $fetched = mysql_fetch_assoc($res);
    $uid = $fetched["id"];
    
    $w1 = mysql_query('SELECT * FROM webservice WHERE id="'.mysql_real_escape_string($uid).'";');
    $w1_fetched = mysql_fetch_assoc($w1);
    
    $l1 = mysql_query('SELECT linktitle,linkURL FROM links WHERE id="'.$uid.'" AND linkid="l1";');
    $l2 = mysql_query('SELECT linktitle,linkURL FROM links WHERE id="'.$uid.'" AND linkid="l2";');
    $l3 = mysql_query('SELECT linktitle,linkURL FROM links WHERE id="'.$uid.'" AND linkid="l3";');
    $l4 = mysql_query('SELECT linktitle,linkURL FROM links WHERE id="'.$uid.'" AND linkid="l4";');
    
    $fetched_l1 = mysql_fetch_assoc($l1);
    $fetched_l2 = mysql_fetch_assoc($l2);
    $fetched_l3 = mysql_fetch_assoc($l3);
    $fetched_l4 = mysql_fetch_assoc($l4);
    
    if(!empty($_POST))
    {   
        //その他のリンクの編集のエラー判定
        
        if($_POST["link1_title"] != "" && $_POST["link_1"] == "") { $error["link1"]["url"] = "url"; }
        if($_POST["link2_title"] != "" && $_POST["link_2"] == "") { $error["link2"]["url"] = "url"; }
        if($_POST["link3_title"] != "" && $_POST["link_3"] == "") { $error["link3"]["url"] = "url"; }
        if($_POST["link4_title"] != "" && $_POST["link_4"] == "") { $error["link4"]["url"] = "url"; }
        
        if($_POST["link1_title"] == "" && $_POST["link_1"] != "") { $error["link1"]["title"] = "title"; }
        if($_POST["link2_title"] == "" && $_POST["link_2"] != "") { $error["link2"]["title"] = "title"; }
        if($_POST["link3_title"] == "" && $_POST["link_3"] != "") { $error["link3"]["title"] = "title"; }
        if($_POST["link4_title"] == "" && $_POST["link_4"] != "") { $error["link4"]["title"] = "title"; }
        
        if(!is_url($_POST["link_1"]) && $_POST["link1_title"] != "" && $_POST["link_1"]!="") { $error["link1"]["type"] = "type"; }
        if(!is_url($_POST["link_2"]) && $_POST["link2_title"] != "" && $_POST["link_2"]!="") { $error["link2"]["type"] = "type"; }
        if(!is_url($_POST["link_3"]) && $_POST["link3_title"] != "" && $_POST["link_3"]!="") { $error["link3"]["type"] = "type"; }
        if(!is_url($_POST["link_4"]) && $_POST["link4_title"] != "" && $_POST["link_4"]!="") { $error["link4"]["type"] = "type"; }
        
        if($_POST["link1_title"] == "" && $_POST["link_1"] == ""){
            $_POST["link1_title"] = NULL;
            $_POST["link_1"] = NULL;
        }
        if($_POST["link2_title"] == "" && $_POST["link_2"] == ""){
            $_POST["link2_title"] = NULL;
            $_POST["link_2"] = NULL;
        }
        if($_POST["link3_title"] == "" && $_POST["link_3"] == ""){
            $_POST["link3_title"] = NULL;
            $_POST["link_3"] = NULL;
        }
        if($_POST["link4_title"] == "" && $_POST["link_1"] == ""){
            $_POST["link4_title"] = NULL;
            $_POST["link_4"] = NULL;
        }
        
        //Webサービス関連のリンクの設定のエラー判定
        if($_POST["twitter_id"] == "") { $_POST["twitter_id"] = NULL; }
        if($_POST["facebook"] == "") { $_POST["facebook"] = NULL; }
        if($_POST["flickr"] == "") { $_POST["flickr"] = NULL; }
        if($_POST["lastfm"] == "") { $_POST["lastfm"] = NULL; }
        if($_POST["linkdin"] == "") { $_POST["linkdin"] = NULL; }
        if($_POST["myspace"] == "") { $_POST["myspace"] = NULL; }
        if($_POST["psn"] == "") {  $_POST["psn"] = NULL; }
        if($_POST["delicious"] == "") { $_POST["delicious"] = NULL; }
        if($_POST["tumblr"] == "") { $_POST["tumblr"] = NULL; }
        if($_POST["youtube"] == "") { $_POST["youtube"] = NULL; }
        if($_POST["amazon"] == "") { $_POST["amazon"] = NULL; }
        if($_POST["deviantart"] == "") { $_POST["deviantart"] = NULL; }
        if($_POST["github"] == "") { $_POST["github"] = NULL; }
        if($_POST["email"] == "") { $_POST["email"] = NULL; }
        if($_POST["skype"] == "") { $_POST["skype"] = NULL; }
        if($_POST["picasa"] == "") { $_POST["picasa"] = NULL; }
        
        if(!preg_match('/[a-zA-Z0-9_]+/',$_POST["twitter_id"]) && $_POST["twitter_id"] != "") { $error["w"]["twitter"] = "type"; }
        if(!preg_match('/http:\/\/www\.facebook\.com\/(profile\.php\?id=[0-9]+|[a-zA-Z0-9.]+)/',$_POST["facebook"]) && $_POST["facebook"] != "") { $error["w"]["facebook"] = "type";}
        if(!preg_match('@http://(www\.)?flickr\.com/(people|photos)/([a-z0-9\@\_\-]+)@is',$_POST["flickr"]) && $_POST["flickr"] != "") {$error["w"]["flickr"] = "type";}
        if(!preg_match('/[A-Za-z0-9_-]+/',$_POST["lastfm"]) && $_POST["lastfm"] != "") {$error["w"]["lastfm"] = "type";}
        if(!preg_match('/http:\/\/www\.myspace\.com\/[A-Za-z0-9._-]+/',$_POST["myspace"]) && $_POST["myspace"] != "") {$error["w"]["myspace"] = "type";}
        if(!preg_match('/[A-Za-z0-9_-]+/',$_POST["psn"]) && $_POST["psn"] != "") { $error["w"]["psn"] = "type"; }
        if(!preg_match('/[A-Za-zx0-9_-]+/',$_POST["delicious"]) && $_POST["delicious"] != "") { $error["w"]["delicious"] = "type"; }
        if(!is_url($_POST["tumblr"]) && $_POST["tumblr"] != "") { $error["w"]["tumblr"] = "type"; }
        if(!is_url($_POST["amazon"]) && $_POST["amazon"] !="") { $error["w"]["amazon"] = "type"; }
        if(!preg_match('/[A-Za-z0-9-]+/',$_POST["deviantart"]) && $_POST["deviantart"] != "") { $error["w"]["deviantart"] = "type"; }
        if(!preg_match('/[A-Za-z0-9-]+/',$_POST["github"]) && $_POST["github"] != "") { $error["w"]["github"] = "type"; }
        if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',$_POST["email"]) && $_POST["email"] != "") { $error["w"]["email"] = "type"; }
        if(!preg_match('/[A-Za-z0-9_,.-]+/',$_POST["skype"]) && $_POST["skype"] != "") { $error["w"]["skype"] = "type"; }
        if(!preg_match('/https:\/\/picasaweb\.google\.com\/[0-9]+\/[0-9]+/',$_POST["picasa"]) && $_POST["picasa"] != "") { $error["w"]["picasa"] = "type"; }
        
                
        if(empty($error))
        {
            if(mb_strlen($_POST["link_1"],"UTF-8") > 46){ $_POST["link_1"] = short(urlencode($_POST["link_1"])); }
            if(mb_strlen($_POST["link_2"],"UTF-8") > 46){ $_POST["link_2"] = short(urlencode($_POST["link_2"])); }
            if(mb_strlen($_POST["link_3"],"UTF-8") > 46){ $_POST["link_3"] = short(urlencode($_POST["link_3"])); }
            if(mb_strlen($_POST["link_4"],"UTF-8") > 46){ $_POST["link_4"] = short(urlencode($_POST["link_4"])); }
            
            $_SESSION["settings_link"] = $_POST;
            header("Location: link_confirm.php");
        }
        
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Verbindung+</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/charCount.js"></script>
    </head>
    <body>
        <div id="continer">
            <span id="head">
                <br>
                <h1><img src="../images/header.png"></h1>
                <p><strong>あなただけの公開プロフィールを簡単に作成、共有する。</strong></p>
                <div id="content">
                    <div id="content_inner">
                        <form action="" method="POST">
                        <span id="mi"><strong>利用中のソーシャルサービスの編集</strong></span><br>
                        <ul>
                        <span id="inner">
                        利用しているソーシャルサービスの中で、プロフィールに表示させたいものがあれば<br />
                        左側のチェックボックスにチェックを入れてください。<br><br>
                        <img src="../images/twitter.png">　 <input type="text" name="twitter_id" id="twitter_id" placeholder="TwitterのユーザーIDを入力..." size="50"class="text" value='<?php if(!is_null($w1_fetched["twitter"])){print(htmlspecialchars($w1_fetched["twitter"],ENT_QUOTES,"UTF-8"));} ?>'><br>
                        <?php if($error["w"]["twitter"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?>
                                                <img src="../images/facebook.png">
                        　<input type="text" name="facebook" id="facebook" placeholder="FacebookのURLを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["facebook"])){print(htmlspecialchars($w1_fetched["facebook"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["facebook"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?><img src="../images/flickr.png">
                    　<input type="text" name="flickr" id="flickr" placeholder="Flickrの個別URLを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["flickr"])){print(htmlspecialchars($w1_fetched["flickr"],ENT_QUOTES,"UTF-8"));} ?>'><br><img src="../images/lastfm.png">　
                                <input type="text" name="lastfm" id="lastfm" placeholder="last.fmのユーザーIDを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["lastfm"])){print(htmlspecialchars($w1_fetched["lastfm"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["lastfm"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?>
                            
                        <img src="../images/linkedin.png"> 
                        　<input type="text" name="linkedin" id="lastfm" placeholder="linkdinのユーザーIDを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["lastfm"])){print(htmlspecialchars($w1_fetched["linkdin"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["linkdin"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?><img src="../images/myspace.png"> 
                        　<input type="text" name="myspace" id="myspace" placeholder="myspaceの個別URLを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["myspace"])){print(htmlspecialchars($w1_fetched["myspace"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["myspace"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?><img src="../images/playstation.png">
                        　<input type="text" name="psn" id="psn" placeholder="PSN(Playstation Network)のユーザーIDを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["psn"])){print(htmlspecialchars($w1_fetched["psn"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["psn"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?><img src="../images/delicious.png"> 
                        　<input type="text" name="delicious" id="delicious" placeholder="delicious.usのユーザーIDを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["delicious"])){print(htmlspecialchars($w1_fetched["delicious"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["delicious"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?><img src="../images/tumblr.png">
                        　<input type="text" name="tumblr" id="tumblr" placeholder="tumblr個別URLを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["tumblr"])){print(htmlspecialchars($w1_fetched["tumblr"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["tumblr"] == "type"): ?><font color="red" size="3">正しい形式で入力してください</font><br><?php endif;?><img src="../images/youtube.png">　<input type="text" name="youtube" id="youtube" placeholder="YoutubeのユーザーIDを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["youtube"])){print(htmlspecialchars($w1_fetched["youtube"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["youtube"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?><img src="../images/amazon.png">　
                        <input type="text" name="amazon" id="amazon" placeholder="Amazon WishlistのURLを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["amazon"])){print(htmlspecialchars($w1_fetched["amazon"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["amazon"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?>
            <img src="../images/deviant-art.png">　 <input type="text" name="deviantart" id="deviantart" placeholder="deviantartのユーザーIDを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["deviantart"])){print(htmlspecialchars($w1_fetched["deviantart"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["deviantart"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?>

                        <img src="../images/github.png">　
                        <input type="text" name="github" id="github" placeholder="GithubのIDを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["github"])){print(htmlspecialchars($w1_fetched["github"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["github"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?>

                        <img src="../images/email.png">　
                        <input type="text" name="email" id="email" placeholder="メールアドレスを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["email"])){print(htmlspecialchars($w1_fetched["email"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["email"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?>
      
                        <img src="../images/skype.png">　
                        <input type="text" name="skype" id="skype" placeholder="Skype IDを入力" size="50" class="text" value='<?php if(!is_null($w1_fetched["skype"])){print(htmlspecialchars($w1_fetched["skype"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["skype"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?>
                        <img src="../images/picasa.png">　
                        <input type="text" name="picasa" id="picasa" placeholder="PicasaのURLを入力..." size="50" class="text" value='<?php if(!is_null($w1_fetched["picasa"])){print(htmlspecialchars($w1_fetched["picasa"],ENT_QUOTES,"UTF-8"));} ?>'><br><?php if($error["w"]["picasa"] == "type"): ?>
                            <font color="red" size="3">正しい形式で入力してください</font><br>
                        <?php endif; ?>

                        　<br>                   
                       </span>
                        <span id="mi">その他のリンクの編集</span><br>
                                <span id="inner">
                                    ブログなどのその他のリンクを追加するにはこのリンクの編集欄にタイトルとURLを記述してください。<br>
                                    [タイトル] - [URL]というような形でプロフィールページに反映されます。<br>
                                    その他のリンクの上限は最大4リンクまでです。<br>
                                    <br>
                                    <img src="../images/hb.png" width="32" height="32">　
                                    <input type="text" name="link1_title" id="link1_title" size="40" placeholder="タイトルを入力" class="text_s" value='<?php if(!is_null($fetched_l1["linktitle"])){print(htmlspecialchars($fetched_l1["linktitle"],ENT_QUOTES,"UTF-8"));} ?>'> 
                                    <input type="text" name="link_1" id="link_1" size="50" placeholder="URLを入力" class="text_s" value='<?php if(!is_null($fetched_l1["linkURL"])){print(htmlspecialchars($fetched_l1["linkURL"],ENT_QUOTES,"UTF-8"));} ?>'><br>
                                    <img src="../images/hb.png" width="32" height="32">　
                                    <input type="text" name="link2_title" id="link2_title" size="40" placeholder="タイトルを入力" class="text_s" value='<?php if(!is_null($fetched_l2["linktitle"])){print(htmlspecialchars($fetched_l2["linktitle"],ENT_QUOTES,"UTF-8"));} ?>'> 
                                    <input type="text" name="link_2" id="link_2" size="50" placeholder="URLを入力" class="text_s" value='<?php if(!is_null($fetched_l2["linkURL"])){print(htmlspecialchars($fetched_l2["linkURL"],ENT_QUOTES,"UTF-8"));} ?>'><br>
                                    <img src="../images/hb.png" width="32" height="32">　
                                    <input type="text" name="link3_title" id="link_3_title" size="40" placeholder="タイトルを入力" class="text_s" value='<?php if(!is_null($fetched_l3["linktitle"])){print(htmlspecialchars($fetched_l3["linktitle"],ENT_QUOTES,"UTF-8"));} ?>'> 
                                    <input type="text" name="link_3" id="link_3" size="50" placeholder="URLを入力" class="text_s" value='<?php if(!is_null($fetched_l3["linkURL"])){print(htmlspecialchars($fetched_l3["linkURL"],ENT_QUOTES,"UTF-8"));} ?>'><br>
                                    <img src="../images/hb.png" width="32" height="32">　
                                    <input type="text" name="link4_title" id="link4_title" size="40" placeholder="タイトルを入力" class="text_s" value='<?php if(!is_null($fetched_l4["linktitle"])){print(htmlspecialchars($fetched_l4["linktitle"],ENT_QUOTES,"UTF-8"));} ?>'> 
                                    <input type="text" name="link_4" id="link_4" size="50" placeholder="URLを入力" class="text_s" value='<?php if(!is_null($fetched_l4["linkURL"])){print(htmlspecialchars($fetched_l4["linkURL"],ENT_QUOTES,"UTF-8"));} ?>'><br>
                                    <br>
                                </span>
                                <br>
                                <a href="../settings.php" class="super button blue" style="border:0;">　<< 設定画面トップ　</a>
                                <input type="submit" class="super button pink" style="border:0;" value="　>> 設定を反映する　">
                                </ul>
                            </form>
                            <br><br><br>
                    </div>
                </div>
            </span>
        </div>
    </body>
</html>