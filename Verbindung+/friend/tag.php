<?php
    session_start();
    $url_f = "http://verbindung.me/friend/tag.php";
    if(strncmp(@$_SERVER["HTTP_REFERER"],$url_f,strlen($url_f)))
    {
        unset($_POST);
    }
    require("../database_connect.php");
    
    if(!isset($_SESSION["username"]))
    {
        header("Location: http://verbindung.me/login.php");
        exit;
    }
      $un = mysql_query('SELECT COUNT(*) AS ct FROM member_info WHERE screen_name="'.mysql_real_escape_string(htmlspecialchars($_GET["id"],ENT_QUOTES)).'";') or die(mysql_error());;
    $un_t = mysql_fetch_assoc($un);
    if($un_t["ct"] == 0)
    {
        header("Location: http://verbindung.me/error.html");
        exit;
    }
    $user_i = htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
    
    $s = 'SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($user_i).'"';
    $res = mysql_query($s) or die(mysql_error());
    $fetched = mysql_fetch_assoc($res);
    $uid = $fetched["id"];
    
    $t1 = mysql_query('SELECT tag FROM other_user_tags WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c1";');
    $t2 = mysql_query('SELECT tag FROM other_user_tags WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c2";');
    $t3 = mysql_query('SELECT tag FROM other_user_tags WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c3";');
    $t4 = mysql_query('SELECT tag FROM other_user_tags WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c4";');
    $t5 = mysql_query('SELECT tag FROM other_user_tags WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c5";');
    $t6 = mysql_query('SELECT tag FROM other_user_tags WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c6";');
    
    $fetched_t1 = mysql_fetch_assoc($t1);
    $fetched_t2 = mysql_fetch_assoc($t2);
    $fetched_t3 = mysql_fetch_assoc($t3);
    $fetched_t4 = mysql_fetch_assoc($t4);
    $fetched_t5 = mysql_fetch_assoc($t5);
    $fetched_t6 = mysql_fetch_assoc($t6);
    
    if(!empty($_POST))
    {
        if($_POST["c1"] == "") { $_POST["c1"] = NULL; }
        if($_POST["c2"] == "") { $_POST["c2"] = NULL; }
        if($_POST["c3"] == "") { $_POST["c3"] = NULL; }
        if($_POST["c4"] == "") { $_POST["c4"] = NULL; }
        if($_POST["c5"] == "") { $_POST["c5"] = NULL; }
        if($_POST["c6"] == "") { $_POST["c6"] = NULL; }
        
        if(empty($error))
        {
            $t_1 = 'UPDATE other_user_tags SET tag="'.mysql_real_escape_string($_POST["c1"]).'" WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c1"';
            $t_2 = 'UPDATE other_user_tags SET tag="'.mysql_real_escape_string($_POST["c2"]).'" WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c2"';
            $t_3 = 'UPDATE other_user_tags SET tag="'.mysql_real_escape_string($_POST["c3"]).'" WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c3"';
            $t_4 = 'UPDATE other_user_tags SET tag="'.mysql_real_escape_string($_POST["c4"]).'" WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c4"';
            $t_5 = 'UPDATE other_user_tags SET tag="'.mysql_real_escape_string($_POST["c5"]).'" WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c5"';
            $t_6 = 'UPDATE other_user_tags SET tag="'.mysql_real_escape_string($_POST["c6"]).'" WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c6"';
            
            mysql_query($t_1) or die(mysql_error());
            mysql_query($t_2) or die(mysql_error());
            mysql_query($t_3) or die(mysql_error());
            mysql_query($t_4) or die(mysql_error());
            mysql_query($t_5) or die(mysql_error());
            mysql_query($t_6) or die(mysql_error());
            
            $username_p = "http://verbindung.me/friend/friend.php?id=".htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
            header("Location: ".$username_p);
        }
    }
    
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Verbindung+</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
    </head>
    <body>
        <div id="continer">
            <span id="head">
                <br>
                <h1><img src="../images/header.png"></h1>
                <p><strong>あなただけの公開プロフィールを簡単に作成、共有する。</strong></p>
                <div id="content">
                    <div id="content_inner">
                        <span id="mi"><strong>ユーザータグの編集</strong></span>
                        <span id="inner">
                            <br>
                                ユーザータグ編集を行います。<br>
                                下の入力フォームに編集したい内容を入力し、確定ボタンを押してください。<br>
                        </span>
                            <br>
                            <form action="" method="POST">
                            <img src="../images/tag.png">
                            <input type="text" name="c1" class="text" placeholder="クラスタを入力..." value='<?php if(!is_null($fetched_t1["tag"])){print(htmlspecialchars($fetched_t1["tag"],ENT_QUOTES,"UTF-8"));}?>'><br>
                            <img src="../images/tag.png">
                            <input type="text" name="c2" class="text" placeholder="クラスタを入力..." value='<?php if(!is_null($fetched_t2["tag"])){print(htmlspecialchars($fetched_t2["tag"],ENT_QUOTES,"UTF-8"));}?>'><br>
                            <img src="../images/tag.png">
                            <input type="text" name="c3" class="text" placeholder="クラスタを入力..." value='<?php if(!is_null($fetched_t3["tag"])){print(htmlspecialchars($fetched_t3["tag"],ENT_QUOTES,"UTF-8"));}?>'><br>
                            <img src="../images/tag.png">
                            <input type="text" name="c4" class="text" placeholder="クラスタを入力..." value='<?php if(!is_null($fetched_t4["tag"])){print(htmlspecialchars($fetched_t4["tag"],ENT_QUOTES,"UTF-8"));}?>'><br>
                            <img src="../images/tag.png">
                            <input type="text" name="c5" class="text" placeholder="クラスタを入力..." value='<?php if(!is_null($fetched_t5["tag"])){print(htmlspecialchars($fetched_t5["tag"],ENT_QUOTES,"UTF-8"));}?>'><br>
                            <img src="../images/tag.png">
                            <input type="text" name="c6" class="text" placeholder="クラスタを入力..." value='<?php if(!is_null($fetched_t6["tag"])){print(htmlspecialchars($fetched_t6["tag"],ENT_QUOTES,"UTF-8"));}?>'><br>
                            <br><br>
                            <center>
                            <a href="http://verbindung.me/" class="super button blue">　<< トップページへ　</a>
                            <input type="submit" class="super button pink" value="　>> 設定を反映させる　" style="border:0;">
                            </center><br><br><br><br>
                        </form>
                    </div>
                </div>
            </span>
        </div>
    </body>
</html>