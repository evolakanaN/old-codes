<?php
    require("../database_connect.php");
    require_once("../twitteroauth/twitteroauth.php");
    
    $query = htmlspecialchars($_GET["uid"],ENT_QUOTES,"UTF-8");
    $s1 = mysql_fetch_assoc(mysql_query('SELECT COUNT(uid) AS xt FROM member_info WHERE uid="'.mysql_real_escape_string($query).'";'));
    $flag = 0;
    if($query == "" || $_GET["url"] == "" || $s1["xt"] == 0) {
        $flag = 1;
    }
    
    if($_GET["title"] == "" && $_GET["url"] != "") {
        $_GET["title"] = $_GET["url"];
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Schwarz - 投稿</title>
        <script type="text/javascript" src="post.js"></script>
        <link rel="stylesheet" href="../style.css">
    </head>
    <body style="overflow:hidden;">
        <div id="line_a" style="height:30px;"></div>
        <div style="height:20px;" id="header_b"></div>
        <br>
        <div id="resp">
            <?php if($flag == 0): ?>
                <span style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;margin-left:20px;">タイトル</span>
                <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;margin:0;"></p>
                <p style="color:gray;margin-top:0px;font-size:1em;margin-left:20px;">
                    <?php
                        print(htmlspecialchars(mb_strimwidth($_GET["title"],0,50,"...",utf8),ENT_QUOTES,"UTF-8"));
                    ?>
                    <input type="hidden" id="url" value="<?php print(urlencode(htmlspecialchars($_GET['url']))); ?>">
                    <input type="hidden" id="title" value="<?php print(htmlspecialchars($_GET['title'])); ?>">
                    <input type="hidden" id="uid" value="<?php print($_GET['uid']); ?>">
                </p>
                <input type="text" id="c" name="comment" style="margin-left:20px;border-radius:5px;width:450px;height:20px;font-size:0.8em;" placeholder="コメントを入力">
                <br>
                <br>
                <button class="btn primary" style="margin-left:20px;width:190px;" onClick="send();">　Twitterに投稿　</button>
            <?php endif; ?>
            <?php if($flag == 1): ?>
                <span style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;margin-left:20px;">エラー</span>
                <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;margin:0;"></p>
                <p style="color:gray;margin-top:0px;font-size:1em;margin-left:20px;">
                    送信されている情報に何らかの誤りがある可能性があります。<br>
                    再度<a href="http://schwarz.verbindung.me/" style="color:#222222;">Schwarz</a>にログインし、<br>
                    ブックマークレットを再発行してください。
                </p>
            <?php endif; ?>
        </div>
            <br>
            <br>
            <div id="header" style="height:100px;"></div>
        </div>
    </body>
</html>