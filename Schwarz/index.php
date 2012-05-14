<?php
    session_start();
    require("database_connect.php");
    if(isset($_SESSION["screen_name"])){
        $u = "http://verbindung.me/schwarz/user.php?id=".$_SESSION["user_id"];
        header("Location: ".$u);
        exit;
    }
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Schwarz</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div id="line_a">
            <span style="float:right;color:#ffffff;margin-right:50px;font-size:0.8em;margin-top:8px;opacity:0.5;"><a href="">トップ</a> | <a href="">新着エントリ</a>
            </span>
        </div>
        <div id="header">
            <div id="he" style="margin:0;width:940px;margin-left:auto;margin-right:auto;">
            <img src="images/header.png" style="margin-left:50px;margin-left:auto;margin-right:auto;float:left;"width="300" height="100">
            <a href="redirect.php" style="margin-top:50px;30px;float:right;text-decoration:none;" class="btn primary">　Sign in with Twitter　</a>
            </div>
        </div>
        <div id="content">
            <span style="font-size:1.5em;color:#615555;font-weight:bold;">見ているページをTwitterでみんなと共有</span>
            <br>
            <span style="font-size:1em;color:#a9a9a9;">Schwarzは今見ているページをTwitterに簡単に投稿し、簡単に閲覧履歴となどを管理できるサービスです。<br>
            登録に必要なのはTwitterアカウントだけ!</span>
            <br>
            <p class="blank"></p>
            <img src="images/tweet.png" class="imgleft" id="n">
            <p class="blank"></p>
            <br>
            <p style="width:100%;height:2px;background-color:#c6c6c6;"></p>
            <span style="font-size:1.5em;color:#615555;font-weight:bold;">ブックマークレット経由の高速投稿</span>
            <br>
            <span style="font-size:1em;color:#a9a9a9;">Schwarzは快適に情報を投稿するために専用のブックマークレットを用意しました。</span>
            <br>
            <p class="blank"></p>
            <img src="images/b1.png" class="imgleft" id="n"> 
            <span style="font-size:0.8em;">
                今までのソーシャルブックマークサービスは投稿する画面を開くのに<br>
                時間が掛かりストレスが溜まりました。でもSchwarzは違います。<br>
                専用のブックマークレットをブラウザに登録して、<br>
                投稿したいサイトを表示したままでそのブックマークレットを押すと<br>
                即座にウィンドウが立ち上がり、ほとんどキー操作のみで高速に投稿が可能です。<br>
                できるだけユーザーに投稿することへのストレスを感じさせないよう努力しました。
            </span>
            <p class="blank"></p>
            <br>
            <p style="width:100%;height:2px;background-color:#c6c6c6;"></p>
             <span style="font-size:1.5em;color:#615555;font-weight:bold;">投稿した情報はSchwarzで管理</span>
            <br>
            <span style="font-size:1em;color:#a9a9a9;">ブックマークレットを通してTwitterに投稿されたサイト情報は同時にあなたのSchwarzにも投稿されます。</span>
            <br>
            <br>
            <span style="font-size:0.8em;">
                投稿された除法はSchwarzにも投稿されてシステムによって自動的に管理されます。<br>
                時間系列順に投稿した履歴を見たり、Schwarz全体でどのサイトが今一番人気があるかなどを<br>
                簡単に調べられます。
            </span>
            <br>
            <br>
            <br>
        </div>
        <div id="footer">
        </div>
    </body>
</html>