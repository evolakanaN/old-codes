<?php
    session_start();
    
    if(!isset($_SESSION["username"]))
    {
        header("Location: http://verbindung.me/error.html");
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Verbindung+</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
    <body>
        <div id="continer">
            <span id="head">
                <br>
                <a href="http://verbindung.me/"><img src="images/header.png"></a>
                <div id="btn_c">
                    <span id="signup_or_login">
                        <?php if(isset($_SESSION["username"])): ?>
                            <a href='<?php print("profile.php?id=".$_SESSION["username"]); ?>' class='medium button green'>　+プロフィールへ戻る　</a>
                        <?php endif; ?>
                    </span>
                </div>
                <p><strong>あなただけの公開プロフィールを簡単に作成、共有する。</strong></p>
      </span>
                <div id="content">
                    <div id="content_inner">
                        <span id="mi"><strong>Verbindung+環境設定</strong></span>
                        <span id="inner">
                            <ul>
                                ここではユーザー情報の設定が行えます。<br>
                                ここで設定したことがあなたのプロフィールページに反映されるようになっています。<br>
                                編集したい項目のボタンをクリックして編集画面にジャンプしてください<br>
                            </ul>
                        </span>
                        <ul>
                            <a href="settings/base.php" class="super button pink">　　 基本プロフィール情報の編集 　　 <br><center><font size="3">表示名や、居住地、勤務先、クラスタ、一言コメントの編集</font></center></a><br><br>
                            <a href="settings/link.php" class="super button blue">　　Webサービス/リンクの編集　　　<br><center><font size="3">Webサービスのアカウント設定や、リンクの編集</font></center></a><br><br>
                            <a href="settings/social.php" class="super button dblue">　　 　　　+Socialの編集　　　　　　<br><center><font size="3">各種ソーシャルネットワークサービスのとの連携</font></center></a><br><br>
                            <a href="../logout.php" class="super button black">　　　　　　 ログアウト 　　　　　　 <br><center><font size="3">Verbindung+からログアウトします</center></font></a>
                        </ul>
                    </div>
                </div>
            </span>
        </div>
    </body>
</html>