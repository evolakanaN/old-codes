<?php
    session_start();
    $url_f = "http://verbindung.me/friend/post_comment.php";
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
     $fu = mysql_fetch_assoc(mysql_query('SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string(htmlspecialchars($_GET["id"],ENT_QUOTES)).'";'));
    $uid = $fu["id"];
    
    $self_id = mysql_fetch_assoc(mysql_query('SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($_SESSION["username"]).'";'));
    
    
    if(!empty($_POST))
    {
        if(mb_strlen($_POST["comment"],"UTF-8") > 140) { $error["comment"]["length"] = "error"; }
        
        if(empty($error)){      
           $sql = 'INSERT INTO user_comments SET self_id="'.mysql_real_escape_string($self_id["id"]).'",to_id="'.mysql_real_escape_string($uid).'",comment_text="'.mysql_real_escape_string($_POST["comment"]).'";';
           
           mysql_query($sql) or die(mysql_error());
           $user_p = "http://verbindung.me/friend/friend.php?id=".htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
           header("Location: ".$user_p);
        }
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Verbindung+</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/charCount.js"></script>
    </head>
    <body>
        <div id="continer">
            <span id="head">
                <br>
                <h1><img src="../images/header.png"></h1>
                <p><strong>あなただけの公開プロフィールを簡単に作成、共有する。</strong></p>
                <div id="content">
                    <div id="content_inner">
                        <span id="mi"><strong>コメントの投稿</strong></span>
                        <form action="" method="POST">
                        <span id="inner">
                            <br>
                                <?php print(htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8")); ?>に対してコメントを投稿します。<br>
                                下の入力フォームに必要な内容を入力し、投稿ボタンを押してください。<br>
                                また、投稿されたコメントは基本的にはこのページの持ち主のユーザーしか削除ができませんので<br>予め了承した上でコメントを投稿してください。
                                <br>
                            <br>
                            <span id="text_comment"><textarea id="comment" name="comment"><?php if(!is_null($fetched_m["comment"])){print(htmlspecialchars($fetched_m["comment"],ENT_QUOTES,"UTF-8"));}?></textarea></span>
                            <script type="text/javascript">
                                $(function() {
                                    $("#comment").charCount({
                                        allowed:140,
                                        warning:30,
                                        counterText:'残り'
                                    });
                                });
                            </script>
                            <style type="text/css">
                            #comment
                            {
                                width:768px;
                                height:150px;
                            }
                            #text_comment .counter
                            {
                                font-size:16px;
                                font-weight:bold;
                                color:#cccccc;
                            }
                            #text_comment .warning { color:#600; }
                            #text_comment .exceeded { color:#e00; }
                            </style>

                            <?php if($error["comment"]["length"] == "error"): ?>
                                <br><font size="4" color="red">*コメントは120文字以上は登録できません。120文字以下で登録してください</font>
                            <?php endif; ?>
                            <br>
                        </span>
                            <br><br>
                            <a href="http://verbindung.me/" class="super button blue">　<< トップへ戻る　</a>
                            <input type="submit" class="super button pink" value="　>> コメントを投稿　" style="border:0;"><br><br><br><br>
                        </form>
                    </div>
                </div>
            </span>
        </div>
    </body>
</html>