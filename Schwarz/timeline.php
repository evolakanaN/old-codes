<?php
    session_start();
    require("database_connect.php");
    
    if(!empty($_POST))
    {
        $s1 = mysql_fetch_assoc(mysql_query('SELECT * FROM '));
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
            <span style="float:right;color:#ffffff;margin-right:50px;font-size:0.8em;margin-top:8px;opacity:0.5;"><a href="">トップ</a> | <a href="">新着エントリ</a> | <a href="">アカウント設定</a> | <strong><a href="">ログアウト</a></strong>
            </span>
        </div>
        <div id="header">
            <div id="he" style="margin:0;width:940px;margin-left:auto;margin-right:auto;">
            <img src="images/header.png" style="margin-left:50px;margin-left:auto;margin-right:auto;float:left;"width="300" height="100">
            </div>
        </div>
        <div id="content">
                <p class="blank"></p>
                    <div style="float:right;">
                        <span style="color:#615555;font-size:1.2em;">メニュー</span>
                        　  <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                            
                        　 <button class="btn primary" style="width:190px;">リスト一覧</button><br>
                        　  <button class="btn info" style="width:190px;">フォロー管理</button><br>
                            <br>
                        　 <button class="btn" style="width:190px;margin-top:5px;">ユーザーページへ</button><br>
                     　  <button class="btn" style="width:190px;">まとめタグ</button><br>
                     　  <button class="btn" style="width:190px;">閲覧した動画</button><br>
                     　  <button class="btn" style="width:190px;">閲覧した画像</button><br>
                     　 <br>
                    <span style="color:#615555;font-size:1.2em;">広告</span>
                    <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                    </div>
                    <span style="color:#615555;font-size:1.2em;font-weight:bold;">タイムライン</span>
                    <p style="width:650px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                    <div id="titlen">
                        <img src="images/sn0wnight.png" class="imgleft" width="64" height="64">
                        <span id="titlenn">【戦国BASARA】真っ赤な空を見ただろうか【信長様の退屈】 - Yo...</span>
                        <br>
                        <span style="color:#009933;font-size:0.7em;">http://www.youtube.com/watch?v=Zm1C6N6x74Q</span>
                        <p style="margin:0;margin-top:3px;margin-left:80px;width:540px;height:1px;background-color:#c6c6c6;"></p>
                        <span style="font-size:0.7em;"><strong>コメント:</strong> [戦国BASARA]</span>
                        <br>
                        <p style="margin:0;margin-top:5px;font-size:0.8em;">
                            <a href="">ブックマーク追加</a>
                            
                        </p>
                    </div>
                    <br>
                    <div id="titlen">
                        <img src="images/sora.png" class="imgleft" width="64" height="64">
                        <span id="titlenn">ラップ歌手の MC Hammer、検索エンジン「WireDoo」を開発...</span>
                        <br>
                        <span style="color:#009933;font-size:0.7em;">http://headlines.yahoo.co.jp/hl?a=20111021-00000007-inet-inet</span>
                        <p style="margin:0;margin-top:3px;margin-left:80px;width:540px;height:1px;background-color:#c6c6c6;"></p>
                        <span style="font-size:0.7em;"><strong>コメント:</strong> ぴゅーと吹くジャガー?</span>
                        <br>
                        <p style="margin:0;margin-top:5px;font-size:0.8em;">
                            <a href="">ブックマーク追加</a>
                            
                        </p>
                    </div>
                    <br>
                    <div id="titlen">
                        <img src="images/tehu.png" class="imgleft" width="64" height="64">
                        <span id="titlenn">アップル</span>
                        <br>
                        <span style="color:#009933;font-size:0.7em;">http://www.apple.com/jp/</span>
                        <p style="margin:0;margin-top:3px;margin-left:80px;width:540px;height:1px;background-color:#c6c6c6;"></p>
                        <span style="font-size:0.7em;"><strong>コメント:</strong> てすとー</span>
                        <br>
                        <p style="margin:0;margin-top:5px;font-size:0.8em;">
                            <a href="">ブックマーク追加</a>
                            
                        </p>
                    </div>
                    <br>
                    
                </p>
           <p class="blank"></p>
        </div>
        <div id="footer">
        </div>
    </body>
</html>
