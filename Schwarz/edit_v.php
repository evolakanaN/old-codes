<?php
    session_start();
    require("database_connect.php");
    
    if(!isset($_SESSION["screen_name"])) {
        header("Location: index.php");
        exit;
    }
    function return_r($_cap){
    $_ts = "";
    $_exp = explode("]",$_cap);
    for($_i=0; $_i<count($_exp); $_i++){
        $_ts .= str_replace("[","",$_exp[$_i]).",";
    }
    $_ret = explode(",",$_ts);
    for($_j=0; $_j<count($_ret); $_j++) {
        if($_ret[$_j] == "" || $_ret[$_j] == NULL) {
            array_splice($_ret,$_j);
        }
    }
    return array_unique($_ret);
    } 
    function conv2id($n) {
        $sn = mysql_fetch_assoc(mysql_query('SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($n).'";'));
        return $sn["id"];
    }
    $query = htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
    $sql = mysql_fetch_assoc(mysql_query('SELECT * FROM member_status WHERE status_id="'.mysql_real_escape_string($query).'";'));
    if(!empty($_POST["sn"])){
        $s4 = mysql_fetch_assoc(mysql_query('SELECT member_id FROM member_status WHERE status_id="'.mysql_real_escape_string($query).'";'));
        if($_SESSION["user_id"] === $s4["member_id"]){
            if($_POST["sn"] == "この内容で確定") {
                //コメントの編集
                mysql_query('DELETE FROM status_tag WHERE member_id="'.mysql_real_escape_string($_SESSION["user_id"]).'" AND site_url="'.mysql_real_escape_string($sql["site_url"]).'";');
                mysql_query('UPDATE member_status SET comment="'.mysql_real_escape_string($_POST["comment_t"]).'" WHERE status_id="'.mysql_real_escape_string($query).'" AND member_id="'.mysql_real_escape_string($_SESSION["user_id"]).'";'); 
                if(preg_match("/\[.*\]/",$_POST["comment_t"],$cap)) {
                    $array = return_r($cap[0]);
                    mysql_query('DELETE FROM status_tag WHERE member_id="'.mysql_real_escape_string($_SESSION["user_id"]).'" AND site_url="'.mysql_real_escape_string($sql["site_url"]).'" created_at=NOW();');
                    
                    for($i=0; $i<count($array); $i++) {
                        mysql_query('INSERT INTO status_tag SET site_url="'.mysql_real_escape_string($sql["site_url"]).'", tag="'.mysql_real_escape_string($array[$i]).'", member_id="'.mysql_real_escape_string($_SESSION["user_id"]).'",created_at=NOW();');
                    }
                }
                $u = "http://verbindung.me/schwarz/video.php?id=".$_SESSION["user_id"];
                header("Location: ".$u);
            }
            else if($_POST["sn"] == "この投稿したサイト情報を削除する")
            {
                //サイト情報の削除
                mysql_query('DELETE FROM member_status WHERE status_id="'.mysql_real_escape_string($query).'" AND member_id="'.mysql_real_escape_string($_SESSION["user_id"]).'";');
                mysql_query('DELETE FROM status_tag WHERE member_id="'.mysql_real_escape_string($_SESSION["user_id"]).'" AND site_url="'.mysql_real_escape_string($sql["site_url"]).'";');
                $u = "http://verbindung.me/schwarz/video.php?id=".$_SESSION["user_id"];
                header("Location: ".$u);
            }
        }
    }
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Schwarz</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="edit.css">
    </head>
    <body>
        <div id="line_a">
            <span style="float:right;color:#ffffff;margin-right:50px;font-size:0.8em;margin-top:8px;opacity:0.5;"><a href="">トップ</a> | <a href="">新着エントリ</a> | <a href="">アカウント設定</a> | <strong><a href="logout.php">ログアウト</a></strong>
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
                     
                    <button class="btn primary" style="margin-left:20px;width:190px;margin-top:5px;">基本設定</button><br>
                     <button class="btn" style="margin-left:20px;width:190px;">共有範囲設定</button><br>
                     <button class="btn" style="margin-left:20px;width:190px;">Twitter関連の設定</button><br>
                     <button class="btn" style="margin-left:20px;width:190px;">FAQ</button><br>
                     <button class="btn" style="margin-left:20px;width:190px;">お問い合わせ</button><br>
                    </div>
                    <div style="width:650px;">
                    <span style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">投稿したサイト情報の編集</span>
                    <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>
                    <br>
                    <div style="padding:10px;width:630px;background-color:#e4e4e4;border-radius:3px;">
                    <span style="color:#615555;font-weight:bold;"><?php print(htmlspecialchars($sql["title"])); ?></span>
                    <br>
                    <span style="font-size:0.8em;color:#009933;"><?php print(htmlspecialchars($sql["site_url"])); ?></span>
                    <p style="width:630px;height:2px;background-color:#a49899;margin-top:5px;margin-bottom:5px;"></p>
                    コメント:<br>
                    <form action="" method="POST">
                        <textarea name="comment_t" style="width:620px;height:25px;font-size:1.2em;"><?php print(htmlspecialchars($sql["comment"])); ?></textarea>
                        <br>
                        <input type="submit" name="sn" class="btn primary" value="この内容で確定">
                    </div>
                    <br>
                    <span style="color:#615555;font-size:1em;">Ads</span>
                    <p style="width:650px;height:1px;background-color:#c6c6c6;margin-top:5px;margin-bottom:5px;"></p>
                    <p style="width:650px;height:1px;background-color:#c6c6c6;margin-top:5px;margin-bottom:5px;"></p>
                    <br>
                    <span style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">サイト情報の削除</span>
                    <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>
                    <br>
                        <input type="submit" name="sn" class="btn danger" style="color:#ffffff;height:40px;margin-left:50px;width:500px;" value="この投稿したサイト情報を削除する">
                    </form>
                </p>
            <br>
           </div>
           <p class="blank"></p>
        </div>
        <div id="footer">
        </div>
    </body>
</html>