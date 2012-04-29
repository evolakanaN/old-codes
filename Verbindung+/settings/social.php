<?php
    session_start();
    require("../database_connect.php");
    
    if(!isset($_SESSION["username"]))
    {
        header("Location: http://verbindung.me/error.html");
    }
    function get_id($s)
    {
        $rn = mysql_fetch_assoc(mysql_query('SELECT id FROM member_info WHERE screen_name="'.$s.'";'));
        return $rn["id"];
    }   
    if(!empty($_POST))
    {           
        if(isset($_POST["twimport_enable"]))
        {    
            $sql = mysql_query('SELECT twitter FROM webservice WHERE id="'.mysql_real_escape_string(get_id($_SESSION["username"])).'";') or die(mysql_error());
            $fetched_tw = mysql_fetch_assoc($sql);
            if($fetched_tw["twitter"] == NULL) { $error["twimport"]["id"] = "not_found"; }
            
            $url_api = "http://twitter.com/users/show.xml?screen_name=".$fetched_tw["twitter"];
            $xml = @simplexml_load_file($url_api);
            
            if(!isset($_POST["display_name"])) { $display_name = NULL; } else if(isset($_POST["display_name"])){ $display_name = (string)$xml->name; }
            if(!isset($_POST["location"])) { $location = NULL; } else if(isset($_POST["location"])) { $location = (string)$xml->location; }
            if(!isset($_POST["description"])) { $description = NULL; } else if(isset($_POST["description"])) { $description = (string)$xml->description; }
            
            if(!isset($_POST["display_name"]) && !isset($_POST["display_name"]) && !isset($_POST["location"]) && !isset($_POST["description"]) && isset($_POST["twimport_enable"])) {
                $error["twimport"]["error"] = "error";
            }
        }
        if(empty($error))
        {
            $_SESSION["social_settings"]["display_name"] = $display_name;
            $_SESSION["social_settings"]["location"] = $location;
            $_SESSION["social_settings"]["description"] = $description;
            
            header("Location: social_confirm.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Verbindung+</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
        <div id="continer">
            <span id="head">
                <br>
                <img src="../images/header.png">
                <p><strong>あなただけの公開プロフィールを簡単に作成、共有する</strong></p>
            </span>
                <div id="content">
                    <div id="content_inner">
                        <span id="mi"><strong>+Social</strong></span><br>
                        <span id="inner">
                            Verbindung+とTwitter,Facebookなどの各ソーシャルネットワークを関連づける機能です。<br>
                            機能は今後のアップデートにより随時追加していく予定です。<br><br><br>
                            <span id="mi">Twimport</span><br>
                            Twitterアカウントをお持ちの方向けの+Social機能です。<br>
                            Verbindung+側での紹介文や居住地などの入力が面倒な方でTwitterアカウントをお持ちの方は、<br>
                            Twimportを有効にして、インポート情報を選択するだけで<br>
                            あなたのTwitterアカウントの紹介文などをVerbindung+のアカウント情報としてインポートできます。<br>
                            <form action="" method="POST">
                            <blockquote>
                                <img src="../images/add.png" width="16" height="16"> <strong>Twitterからインポートする情報:</strong>
                                <input type="checkbox" name="display_name"> 表示名
                                <input type="checkbox" name="location"> 所在地(Location)
                                <input type="checkbox" name="description"> 自己紹介文
                                <br>
                                <img src="../images/sync.png" width="16" height="16"> <strong>Twimport機能を有効にする(設定は保存されません):</strong> <input type="checkbox" name="twimport_enable"><br>
                                <?php if($error["twimport"]["id"] == "not_found"): ?>
                                    <font color="red" size"3">*Twitter登録情報が見つかりません。設定画面からTwitterアカウントを追加してください。</font><br>
                                <?php endif; ?>
                                <?php if($error["twimport"]["error"] == "error"): ?>
                                    <font color="red" size="3">*インポートする情報を選択してください</font><br>
                                <?php endif; ?>
                            </blockquote>
                                <br>
                                <br>
                                <center>
                                <a href="http://verbindung.me/settings.php" class="super button blue">　<< 設定一覧へ戻る　</a>
                                <input type="submit" class="super button pink" style="border:0;" value="　>> 設定を反映する　">
                                </center>
                            </form>
                            
                            <br><br><br><br><br>
                        </span>
                    </div>
                </div>
            </span>
        </div>
    </body>
</html>