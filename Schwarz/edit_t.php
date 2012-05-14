<?php
    session_start();
    require("database_connect.php");
    if(!isset($_SESSION["screen_name"])){
        header("Location: http://verbindung.me/schwarz/");
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
    function convert($scr){
        $s1 = mysql_fetch_assoc(mysql_query('SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($scr).'";'));
        return $s1["id"];
    }
    $query = htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
    $q_tag = htmlspecialchars($_GET["tag"],ENT_QUOTES,"UTF-8");
    $s1 = mysql_fetch_assoc(mysql_query('SELECT * FROM status_tag WHERE member_id="'.mysql_real_escape_string($query).'" AND tag="'.mysql_real_escape_string($q_tag).'";'));
    if(!empty($_POST))
    {
        if($s1["member_id"] === $_SESSION["user_id"])
        {
            if($_POST["sn"] == "この内容で確定") {
                mysql_query('UPDATE status_tag SET tag="'.mysql_real_escape_string($_POST["tag_name"]).'",created_at=NOW() WHERE member_id="'.mysql_real_escape_string($_SESSION["user_id"]).'" AND tag="'.mysql_real_escape_string($s1["tag"]).'";');
                
                $delee =mysql_query('SELECT member_status.comment,status_tag.tag FROM member_status,status_tag WHERE member_status.member_id="'.mysql_real_escape_string($s1["member_id"]).'" AND member_status.member_id=status_tag.member_id AND member_status.site_url=status_tag.site_url AND status_tag.tag="'.mysql_real_escape_string($_POST["tag_name"]).'";');
                
                /*$url = "http://verbindung.me/schwarz/tag.php?id=".$_SESSION["user_id"];
                header("Location: ".$url);
                */
            }
            else if($_POST["sn"] == "タグ情報を削除する") {
            
                mysql_query('DELETE FROM status_tag WHERE member_id="'.mysql_real_escape_string($_SESSION["user_id"]).'" AND tag="'.mysql_real_escape_string($s1["tag"]).'";');
                
                $delee =mysql_query('SELECT member_status.comment,status_tag.tag FROM member_status,status_tag WHERE member_status.member_id="'.mysql_real_escape_string($s1["member_id"]).'" AND member_status.member_id=status_tag.member_id AND member_status.site_url=status_tag.site_url AND status_tag.tag="'.mysql_real_escape_string($_POST["tag_name"]).'";');
                
                while($dddnn = mysql_fetch_assoc($delee)) {
                        if(preg_match("/\[".$q_tag."\]/",$dddnn["comment"])) {
                        $changed = str_replace("[".$q_tag."]","",$dddnn["comment"]);
                        mysql_query('UPDATE member_status,status_tag SET member_status.comment="'.mysql_real_escape_string($changed).'" WHERE member_status.member_id="'.mysql_real_escape_string($s1["member_id"]).'" AND member_status.member_id=status_tag.member_id AND member_status.site_url=status_tag.site_url AND status_tag.tag="'.mysql_real_escape_string($dddnn["tag"]).'";');
                        }
                }
                /*
                mysql_query('DELETE FROM status_tag WHERE member_id="'.mysql_real_escape_string($_SESSION["user_id"]).'" AND tag="'.mysql_real_escape_string($s1["tag"]).'";');
                $delee = mysql_query('SELECT comment FROM member_status WHERE member_id="'.mysql_real_escape_string($_SESSION["user_id"]).'" AND tag="'.mysql_real_escape_string($s1["tag"]).'";');
                while($delete_data = mysql_fetch_assoc($delee)) {
                    if(preg_match("/\[.*\]/",$delete_data["comment"],$capped)) {
                        $source = $delete_data["comment"];
                        $changed = str_replace($capped[0],"",$source);
                        mysql_query('UPDATE member_status,status_tag SET member_status.comment="'.mysql_real_escape_string($changed).'" WHERE member_status.member_id="'.mysql_real_escape_string($s1["member_id"]).'" AND member_status.member_id=status_tag.member_id AND member_status.site_url=status.tag.site_url AND status_tag.tag="'.mysql_real_escape_string($s1["tag"]).'";');
                    }
                }
                */
                $url = "http://verbindung.me/schwarz/tag.php?id=".$_SESSION["user_id"];
                header("Location: ".$url);
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
        <form action="" method="POST">
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
                    <span style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">タグ情報の編集</span>
                    <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>
                    <br>
                    <div style="padding:10px;width:630px;background-color:#e4e4e4;border-radius:3px;">
                    タグ名:<br>
                
                        <textarea name="tag_name" style="width:620px;height:25px;font-size:1.2em"><?php print(htmlspecialchars($s1["tag"])); ?></textarea>
                        <br>
                        <br>
                        <input type="submit" name="sn" class="btn primary" value="この内容で確定">
                    </div>
                    <br>
                    <span style="color:#615555;font-size:1em;">Ads</span>
                    <p style="width:650px;height:1px;background-color:#c6c6c6;margin-top:5px;margin-bottom:5px;"></p>
                    <p style="width:650px;height:1px;background-color:#c6c6c6;margin-top:5px;margin-bottom:5px;"></p>
                    <br>
                    <span style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">タグの削除</span>
                    <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>
                    <br>
                    <input type="submit" name="sn" class="btn danger" style="color:#ffffff;height:40px;margin-left:50px;width:500px;" value="タグ情報を削除する">
                </p>
            <br>
           </div>
           <p class="blank"></p>
        </div>
        </form>
        <div id="footer">
        </div>
    </body>
</html>