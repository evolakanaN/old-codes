<?php
    session_start();
    require("database_connect.php");
    require("functions.php");
    
            if(!empty($_POST))
            {
                if(!check_screen_name($_POST["screen_name"])){ $error["screen_name"] = "error"; }
                if(!$_POST["display_name"]) { $error["display_name"] = "error"; }
                if(mb_strlen($_POST["password"],"UTF-8") < 4) { $error["password"]["length"] = "length"; }
                if(!check_screen_name($_POST["password"])){$error["password"]["etc"] = "etc";}
                if(mb_strlen($_POST["display_name"] > 20)) { $error["display_name"] = "error"; }
                if(empty($error))
                {
                    $s = 'SELECT COUNT(*) AS cnt FROM member_info WHERE screen_name="'.mysql_real_escape_string($_POST["screen_name"]).'" LIMIT 1;';
                    $re = mysql_query($s) or die(mysql_error());
                    $data = mysql_fetch_assoc($re);
                
                    if($data["cnt"] > 0)
                    {
                        $error["screen_name"] = "duplicate";
                    }
                }
                if(empty($error))
            {
                $_SESSION["join"] = $_POST;
                header("Location:check.php");
            }
            }
        ?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Verbindung+ >> 新規アカウント登録</title>
        <link rel="stylesheet" type="text/css" href="http://verbindung.me/css/style.css"> 
    </head>
    <body>
        <div id="continer">
            <span id="head">
            <br>
            <h1><a href="http://verbindung.me/"><img src="http://verbindung.me/images/header.png"></a></h1>
            <p>
                <strong>あなただけの公開プロフィールを簡単に作成、共有する</strong></p>
            </p>
            <div id="content">
                <div id="content_inner">
                    <span id="mi">
                        <strong>新規Verbindung+アカウントの作成</strong>
                    </span>
                    <br>
                    <span id="inner">
                        <ul>
                            早速Verbindung+のアカウントを作成しましょう。<br>
                            下に表示されているフォームに必要事項を入力してピンクのボタンを押してください。<br>
                            以下に表示されているフォームへの入力はすべて必須です。<br>
                            
                            <form action="" method="POST" class="submit_form">
                                    <br>
                                    <input type="text" name="screen_name" class="text" placeholder="希望するユーザーIDを入力..." maxlength="20"><br>
                                    <?php if($error["screen_name"] == "error"): ?>
                                        <font color="red">*ユーザーIDを入力,または日本語や記号の入力はできません</font><br>
                                    <?php endif; ?>
                                    <?php if($error["screen_name"] == "duplicate"): ?>
                                        <font color="red">*ユーザーIDが重複しています。異なるIDでお試しください</font>
                                    <?php endif; ?>
                                    
                                    <input type="text" name="display_name" class="text" placeholder="希望する表示名を入力..." maxlength="20"><br>
                                    <?php if($error["display_name"] == "error"): ?>
                                        <font color="red">*表示名を入力してください</font><br>
                                    <?php endif; ?>
                                    
                                    <input type="password" name="password" class="text" placeholder="希望するパスワードを入力..." maxlength="20"><br>
                                    <?php if($error["password"]["length"] == "length"): ?>
                                        <font color="red">*パスワードは4文字以上で入力してください</font><br>
                                    <?php endif; ?>
                                    <?php if($error["password"]["etc"] == "etc"): ?>
                                        <font color="red">*パスワードには全角文字や記号などは使用できません</font><br>
                                    <?php endif; ?>
                                    <br>
                                    <a href="index.html" class="super button blue">　<< 戻る(トップへ)　</a>
                                    <input type="submit" class="super button pink" value="　>> 進む(確認)　" style="border:0;">
                           </form><br><br>
                        </ul>
                    </span>
                </div>
            </div>       
        </div>
    </body>
</html>