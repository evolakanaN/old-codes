<?php
    session_start();
    require("database_connect.php");
    
    $query = htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
    function conv2id($n) {
        $sn = mysql_fetch_assoc(mysql_query('SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($n).'";'));
        return $sn["id"];
    }
    if(!empty($_POST)) {
        $check = mysql_fetch_assoc(mysql_query('SELECT member_id FROM member_status WHERE status_id="'.mysql_real_escape_string($query).'";'));
        if($check["member_id"] == $_SESSION["user_id"]) {
            $sql = mysql_query('DELETE FROM member_status WHERE status_id="'.mysql_real_escape_string($query).'";');
            $u = "http://verbindung.me/schwarz/page.php?id=".$_SESSION["user_id"];
            header("Location: ".$u);
        }
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
                    <span style="color:#615555;font-size:1.2em;">広告</span>
                    <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                    </div>
                    <div style="width:650px;">
                    <a href="" style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">選択したサイトを削除</a>
                    <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>
                    <br>
                        選択したサイト情報をSchwarzから削除します。本当に削除してよろしいですか?<br>
                        (<span style="color:red;">削除した情報は二度と復元することはできません</span>)<br>
                        <br>
                        <form action="" method="POST">
                            <input type="hidden" value="<?php print(htmlspecialchars($query)); ?>" name="id">
                            <input type="button" class="btn" value="キャンセル" style="width:180px;">
                            <input type="submit" class="btn danger" value="削除する" style="width:180px;">
                        </form>
                    <br>
                </p>
            <br>
           </div>
           <p class="blank"></p>
        </div>
        <div id="footer">
        </div>
    </body>
</html>