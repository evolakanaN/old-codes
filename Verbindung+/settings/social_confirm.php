<?php
    session_start();
    require("../database_connect.php");
    require("../functions.php");
    
    if(!isset($_SESSION["username"]))
    {
        header("Location: error.html");
        exit;
    }
    if(!empty($_POST))
    {
         if(!check_screen_name($_POST["password"])) { $error["password"]["etc"] = "etc"; }
            if($_POST["password"] == "") { $error["password"]["length"] = "error"; }
        
            if(empty($error))
            {
                $id_s = 'SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($_SESSION["username"]).'";';
                $id_res = mysql_query($id_s);
                $id_fetched = mysql_fetch_assoc($id_res);
                $uid = $id_fetched["id"];
                
                $sq1 = 'SELECT * FROM member_info WHERE screen_name="'.mysql_real_escape_string($_SESSION["username"]).'" AND password="'.sha1(mysql_real_escape_string($_POST["password"])).'";';
            
                $re = mysql_query($sq1) or die(mysql_error());
                if($data = mysql_fetch_assoc($re))
                {
                    if($data["screen_name"] == $_SESSION["username"])
                    {
                        /* member_infoテーブルにタッチする所 */
                        if(!is_null($_SESSION["social_settings"]["display_name"])) {
                            $sql_out_info = 'UPDATE member_info SET display_name="'.mysql_real_escape_string($_SESSION["social_settings"]["display_name"]).'" WHERE id="'.$data["id"].'";';
                            mysql_query($sql_out_info) or die(mysql_error());
                        }                    
                        /*member_infoターブルにタッチする所終了*/
                        
                        /*member_profileテーブルにタッチする所開始*/
                        if(!is_null($_SESSION["social_settings"]["location"]) && !is_null($_SESSION["social_settings"]["description"])) {
                            $sql_out_profile = 'UPDATE member_profile SET location="'.mysql_real_escape_string($_SESSION["social_settings"]["location"]).'",comment="'.mysql_real_escape_string($_SESSION["social_settings"]["description"]).'" WHERE id="'.$data["id"].'";';
                            mysql_query($sql_out_profile) or die(mysql_error());
                        }
                        if(is_null($_SESSION["social_settings"]["location"]) && !is_null($_SESSION["social_settings"]["description"])) {
                            $sql_out_profile = 'UPDATE member_profile SET comment="'.mysql_real_escape_string($_SESSION["social_settings"]["description"]).'" WHERE id="'.$data["id"].'";';
                            mysql_query($sql_out_profile) or die(mysql_error());
                        }
                        if(!is_null($_SESSION["social_settings"]["location"]) && is_null($_SESSION["social_settings"]["description"])) {
                            $sql_out_profile = 'UPDATE member_profile SET location="'.mysql_real_escape_string($_SESSION["social_settings"]["location"]).'" WHERE id="'.$data["id"].'";';
                            mysql_query($sql_out_profile) or die(mysql_error());
                        }
                        /*member_profileテーブルにタッチする所終了*/
                        $user_p = "http://verbindung.me/id/".$_SESSION["username"];
                        header("Location: ".$user_p);
                    }
                }
                else
                {
                    $error["login"] = "failed";
                }
            }
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Verbindung+</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
            <div id="continer">
            <span id="head">
            <br>
            <img src="../images/header.png">
            <p><strong>あなただけの公開プロフィールを簡単に作成、共有する</strong></p>
            <div id="content">
                <div id="content_inner">
                    <span id="mi"><strong>認証</strong></span><br>
                    <span id="inner">
                        編集した情報を反映させます。<br>
                        セキュリティチェックのためにあなたのアカウントのパスワードを入力しボタンを押してください。<br>
                        パスワードが正しければ、編集した情報があなたのVerbindung+アカウント情報として登録されます。<br>
                        <form class="submit_form" action="" method="POST"><br>
                        <input type="hidden" name="action" value="submit">
                                                    <p id="description_background"><br>
                                    　　　　　　　<input type="password" name="password" placeholder="あなたのパスワードを入力..." class="text"><br>
                                    　　　　　　　<?php if($error["password"]["etc"] == "etc"): ?>
                                    　　　　　　　     <font size="3" color="red">*パスワードには日本語や記号は入力できません。</font><br>
                                    　　　　　　　<?php endif; ?>
                                    　　　　　　　<?php if($error["password"]["length"] == "error"): ?>
                                    　　　　　　　     <font size="3" color="red">*パスワードを入力してください。</font><br>
                                    　　　　　　　 <?php endif; ?>
                                    　　　　　　　<?php if($error["login"] == "failed"): ?>
                                    　　　　　　　     <font size="3" color="red">*ログインに失敗しました。</font><br>
                                    　　　　　　　<?php endif; ?>
                                </p>
                                <br>
                                <a href="http://verbindung.me/" class="super button blue">　<< 戻る(トップへ)　</a> 
                                <input type="submit" class="super button pink" value="　>> 内容を反映させる　" style="border:0;">
                        </form>
                    </span>
                </div>
            </div>
    </body>
</html>