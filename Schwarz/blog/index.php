<?php
    require("../database_connect.php");
    $s1 = mysql_query('SELECT * FROM schwarz_blog ORDER BY entry_id DESC LIMIT 0,10');
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
                            
                        　 <button class="btn primary" style="width:190px;">トップページ</button><br>
                        　  <button class="btn info" style="width:190px;">開発者について</button><br>
                            <br>
                        　 <button class="btn" style="width:190px;margin-top:5px;">機能追加情報</button><br>
                     　  <button class="btn" style="width:190px;">バグ修正情報</button><br>
                     　  <button class="btn" style="width:190px;">イベント情報</button><br>
                     　  <button class="btn" style="width:190px;">未分類</button><br>
                     　 <br>
                    </div>
                    <div style="width:650px;">
                    <?php
                        $output = '';
                        while($data = mysql_fetch_assoc($s1))
                        {
                            $output .= '<a href="entry.php?id='.htmlspecialchars($data["entry_id"]).'" style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">'.htmlspecialchars($data["title"]).'</a>';
                            $output .= '<p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>';
                            $output .= '<span style="font-size:0.7em;">published at:'.htmlspecialchars($data["timestamp"]).' - <a href="edit.php?id='.htmlspecialchars($data["entry_id"]).'">Edit</a></span>';
                            $output .= '<br><br>';
                            $output .= '<span style="font-size:0.9em;">'.nl2br($data["body"]).'</span>';
                            $output .= '<br><br><br>';
                        }
                        print($output);
                    ?>
                    <br>
                </p>
            <br>
           </div>
        </div>
        <p class="blank"></p>
        <div id="footer">
        </div>
    </body>
</html>