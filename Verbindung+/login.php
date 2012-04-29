<?php
    session_start();
    require("database_connect.php");
    
    if(isset($_SESSION["username"]))
    {
        $u = "http://verbindung.me/id/".$_SESSION["username"];
        header("Location:".$u);
        exit;
    }
    $q_redirect = htmlspecialchars($_GET["redirect"],ENT_QUOTES,"UTF-8");
    if(!empty($_POST))
    {
        if($_POST["username"] != "" && $_POST["password"] != "")
        {
            $sq1 = 'SELECT * FROM member_info WHERE screen_name="'.mysql_real_escape_string($_POST["username"]).'" AND password="'.sha1(mysql_real_escape_string($_POST["password"])).'"';
            $re = mysql_query($sq1) or die(mysql_error());
            
            if($data = mysql_fetch_assoc($re))
            {
                $_SESSION["username"] = $data["screen_name"];
                $username_p = "http://verbindung.me/id/".$_POST["username"];
                $redirect_u = "http://verbindung.me/friend/friend.php?id=".$q_redirect;
                $_SESSION["time"] = time();
                if($q_redirect != "")
                {
                    header("Location:".$redirect_u);
                }
                header("Location:".$username_p);
            }
            else
            {
                $error["login"] = "failed";
            }
        }
        else
        {
            $error["login"] = "blank";
        }
    }
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Verbindung+</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div id="continer">
            <span id="head">
                <br>
                <a href="http://verbindung.me/"><img src="images/header.png"></a>
                <p><strong>あなただけの公開プロフィールを簡単に作成、共有する</strong></p>
            </span>
            <div id="content">
                <div id="content_inner">
                    <form action="" method="POST">
                        <span id="mi"><strong>Verbindung+にログイン</strong></span><br>
                        <ul>
                        <span id="inner">
                        Verbindung+にログインするには下の入力フォームにユーザーIDとパスワードを入力してください。<br>
                        ログイン後、個別ページに自動的にアクセスします。<br><br>
                        
                        <input type="text" name="username" class="text" placeholder="ユーザーIDを入力..."><br>
                        <input type="password" name="password" class="text" placeholder="パスワードを入力..."><br>
                        <?php if($error["login"] == "blank"): ?>
                            <font color="red">*ユーザーIDまたはパスワードを正しく入力してください</font><br>
                        <?php endif; ?>
                        <?php if($error["login"] == "failed"): ?>
                            <font color="red">*ログインに失敗しました</font><br>
                        <?php endif; ?>
                        <br>
                        <a href="index.html" class="super button blue" style="border:0;">　<< トップへ戻る　</a>
                        <input type="submit" class="super button pink" value="　>> ログイン　" style="border:0;">
                    </form>
                    <br><br>
                    </ul>
                    </span>
                </div>
            </div>
        </div>
    </body>
</html>