<?php
    session_start();
    require("../database_connect.php");
    
    function convert($scr) {
        $sql = mysql_fetch_assoc(mysql_query('SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($scr).'";'));
        return $sql["id"];
    }
    if($_SESSION["user_id"] != "23061579"){
        header("Location: http://verbindung.me/schwarz/error.html");
        exit;
    }
    $query = htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
    $sq = mysql_fetch_assoc(mysql_query('SELECT * FROM schwarz_blog WHERE entry_id="'.mysql_real_escape_string($query).'";'));
    if(!empty($_POST))
    {
        if($_POST["title"] == "") { $error["title"]; }
        if($_POST["tag"] == "") { $error["tag"]; }
        if($_POST["body"] == "") { $error["body"]; }
        
        if(empty($error))
        {
            mysql_query('UPDATE schwarz_blog SET title="'.mysql_real_escape_string($_POST["title"]).'",body="'.mysql_real_escape_string($_POST["body"]).'" WHERE entry_id="'.mysql_real_escape_string($query).'";');
            header("Location: http://verbindung.me/schwarz/blog/");             
        }
    }
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Schwarz</title>
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
        <div id="line_a">
            <span style="float:right;color:#ffffff;margin-right:50px;font-size:0.8em;margin-top:8px;opacity:0.5;"><a href="">トップ</a> | <a href="">新着エントリ</a> | <a href="">アカウント設定</a> | <strong><a href="">ログアウト</a></strong>
            </span>
        </div>
        <div id="header">
        </div>
        <div id="content">
                <p class="blank"></p>
                    <div style="float:right;">
                        <span style="color:#615555;font-size:1.2em;">メニュー</span>
                     　  <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                     　  <button class="btn primary" style="width:190px;margin-top:5px;" onClick="location.href='http://verbindung.me/schwarz/b/';">ブログへ</button><br>
                     　  <button class="btn" style="width:190px;">過去記事の編集</button><br>
                     　  <button class="btn" style="width:190px;">過去記事の削除</button><br>
                     　 <br>
                    </div>
                    <div style="width:650px;">
                    <a href="" style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">新規記事の投稿</a>
                    <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>
                    <br>
                        <form action="" method="POST">
                        タイトル:
                        <textarea name="title" style="width:650px;height:30px;font-size:1.5em;"><?php print(htmlspecialchars($sq["title"])); ?></textarea>
                        <br>
                        ブログ本文(HTMLタグが使用できます)
                        <br>
                        <textarea name="body" style="width:650px;height:500px;font-size:1em;"><?php print(htmlspecialchars($sq["body"])); ?></textarea>
                        <br>
                        <br>
                        <input type="submit" style="width:650px;height:30px;"class="btn primary" value="投稿する">
                        </form>
                    <br>
                    <p class="blank"></p>
                </p>
            <br>
           </div>
        </div>
        <div id="footer">
        </div>
    </body>
</html>