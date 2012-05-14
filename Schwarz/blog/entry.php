<?php
    require("../database_connect.php");
    $query = htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
    $s1 = mysql_fetch_assoc(mysql_query('SELECT * FROM schwarz_blog WHERE entry_id="'.mysql_real_escape_string($query).'";'));
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
             <div id="he" style="margin:0;width:940px;margin-left:auto;margin-right:auto;">
            <img src="../images/header.png" style="margin-left:50px;margin-left:auto;margin-right:auto;float:left;"width="300" height="100">
            </div>
        </div>
        <div id="content">
                <p class="blank"></p>
                    <div style="float:right;">
                        <span style="color:#615555;font-size:1.2em;">メニュー</span>
                     　  <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                     　 <br>
                    </div>
                    <div style="width:650px;">
                    <a href="" style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.4em;"><?php print(htmlspecialchars($s1["title"])); ?></a>
                    <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>
                    <span style="font-size:0.7em;">published at: <?php print(htmlspecialchars($s1["timestamp"])); ?></span>
                    <br>
                    <br>
                    <?php print(nl2br($s1["body"])); ?>
                    <br>
                    <br>
                    </div>
                    <br>
                </p>
            <br>
           </div>
        </div>
        <div id="footer">
        </div>
    </body>
</html>