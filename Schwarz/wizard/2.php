<?php
    session_start();
    require("../database_connect.php");
    require("../twitteroauth/twitteroauth.php");
    
    if(!isset($_SESSION["user_id"]))
    {
        header("Location: http://verbindung.me/schwarz/");
        exit;
    }
    $ss1 = mysql_fetch_assoc(mysql_query('SELECT uid FROM member_info WHERE id="'.mysql_real_escape_string($_SESSION["user_id"]).'";'));
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Schwarz</title>
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
        <div id="line_a">
            <span style="float:right;color:#ffffff;margin-right:50px;font-size:0.8em;margin-top:8px;opacity:0.5;"><a href="">トップ</a> | <a href="">新着エントリ</a> | <a href="">アカウント設定</a> | <strong><a href="redirect.php">Sign in with Twitter</a></strong>
            </span>
        </div>
        <div id="header">
            <div id="he" style="margin:0;width:940px;margin-left:auto;margin-right:auto;">
            <img src="../images/header.png" style="margin-left:50px;margin-left:auto;margin-right:auto;float:left;"width="300" height="100">
            </div>
        </div>
        <div id="content">
            <span style="font-size:1.5em;color:#615555;font-weight:bold;">(1/3) 投稿用ブックマークレット</span>
            <br>
            <img src="../images/b.png" class="imgleft" width="300" height="192">
            <ul>
            <span style="font-size:1em;color:#a9a9a9;">
            はじめにまず、投稿用のブックマークレットを設定してください。<br>
            Schwarzにはブックマークレットが2種類存在し、投稿用のブックマークレットとSpeedJumpといいます。<br>
            投稿用ブックマークレットはその名の通り、サイト情報を投稿するブックマークレットです。<br>
            下の白いボタンをブラウザのブックマーク欄にドラッグ&ドロップしてください。</span>
            <br>
            <br>
            <a href="javascript:void(window.open('http://verbindung.me/schwarz/bookmarklet/main.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href)+'&uid=<?php print(htmlspecialchars($ss1['uid'])); ?>',null,'width=530,height=270'))" alt="" style="text-decoration:none;" class="btn" style="text-decoration:none;">　　Schwarz(投稿)　　</a>
            </ul>
            <br>
            <br>
            <input type="button" class="btn primary" style="width:350px;" value="次へ(2/3)"><br>
            <br>
            <br>
            <br>
        </div>
        <div id="footer">
        </div>
    </body>
</html>
