<?php
    session_start();
    require("../database_connect.php");
    
    if(!isset($_SESSION["username"]))
    {
        header("Location: http://verbindung.me/error.html");
        exit;
    }
    $s = 'SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($_SESSION["username"]).'"';
    $res = mysql_query($s) or die(mysql_error());
    $fetched = mysql_fetch_assoc($res);
    $uid = $fetched["id"];
    
    $member = 'SELECT * FROM member_profile WHERE id="'.$uid.'"';
    $member_res = mysql_query($member) or die(mysql_error());
    $fetched_m = mysql_fetch_assoc($member_res);
    
    $display_name_s = 'SELECT display_name FROM member_info WHERE id="'.$uid.'"';
    $d_name_s = mysql_query($display_name_s) or die(mysql_error());
    $fetched_d = mysql_fetch_assoc($d_name_s);
    
    $t1 = mysql_query('SELECT tag FROM user_tags WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c1";');
    $t2 = mysql_query('SELECT tag FROM user_tags WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c2";');
    $t3 = mysql_query('SELECT tag FROM user_tags WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c3";');
    $t4 = mysql_query('SELECT tag FROM user_tags WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c4";');
    $t5 = mysql_query('SELECT tag FROM user_tags WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c5";');
    $t6 = mysql_query('SELECT tag FROM user_tags WHERE id="'.mysql_real_escape_string($uid).'" AND tagid="c6";');
    
    $fetched_t1 = mysql_fetch_assoc($t1);
    $fetched_t2 = mysql_fetch_assoc($t2);
    $fetched_t3 = mysql_fetch_assoc($t3);
    $fetched_t4 = mysql_fetch_assoc($t4);
    $fetched_t5 = mysql_fetch_assoc($t5);
    $fetched_t6 = mysql_fetch_assoc($t6);
    
    if(!empty($_POST))
    {
        if(!$_POST["display_name"]) { $error["display_name"] = "error"; }
        if(mb_strlen($_POST["comment"],"UTF-8") > 120) { $error["comment"]["length"] = "error"; }
        
        if($_POST["c1"] == "") { $_POST["c1"] = NULL; }
        if($_POST["c2"] == "") { $_POST["c2"] = NULL; }
        if($_POST["c3"] == "") { $_POST["c3"] = NULL; }
        if($_POST["c4"] == "") { $_POST["c4"] = NULL; }
        if($_POST["c5"] == "") { $_POST["c5"] = NULL; }
        if($_POST["c6"] == "") { $_POST["c6"] = NULL; }
        
        $fn = $_FILES["sel_image"]["name"];
        $user_file = $_FILES["sel_image"]["tmp_name"];
        $ftype = "";
        if(!empty($fn))
        {
            if(preg_match("/^.+\.jpeg$/i",$fn) OR preg_match("/.+\.jpg$/i",$fn)){
	           $ftype = "JPG";
            }elseif(preg_match("/^.+\.png$/i",$fn)){
	           $ftype = "PNG";
            }elseif(preg_match("/^.+\.gif$/i",$fn)){
	           $ftype = "GIF";
            }else{
	           $error["image"] = "type";
            }
        }
        if(empty($error)){           
                $image = time().".".$_FILES["sel_image"]["name"];
                if($fn == ""){
                    $image = $fetched_m["profile_image"];
                }
                else if($fn == $_FILES["sel_image"]["name"]){
                    list($width,$height) = getimagesize($_FILES["sel_image"]["tmp_name"]);
                    $blank_img = imagecreatetruecolor($width+1,$height+1);
                    switch($ftype){
                        case "JPG":
                            $user_img = @imagecreatefromjpeg($user_file);
                        break;
                        case "PNG":
                            $user_img = @imagecreatefrompng($user_file);
                        break;
                        case "GIF":
                            $user_img = @imagecreatefromgif($user_file);
                        break;
                    }
                    imagecopy($blank_img,$user_img,0,0,0,0,$width+1,$height+1);
                    switch($ftype){
                        case "JPG":
                            @imagejpeg($user_img,$user_file);
                        break;
                        case "PNG":
                            @imagepng($user_img,$user_file);
                        case "GIF":
                            @imagegif($user_img,$user_file);
                    }
                    @imagedestroy($blank_img);
                    @imagedestroy($user_img);

                    if($_FILES["sel_img"]["size"] < 8000){
                        move_uploaded_file($_FILES["sel_image"]["tmp_name"],"../member/profile_image/".$image);
                    }     
                    $_SESSION["settings_base"] = $_POST;
                    $_SESSION["settings_base"]["image"] = $image;
                    header("Location: base_confirm.php");
                }
                $_SESSION["settings_base"] = $_POST;
                    $_SESSION["settings_base"]["image"] = $image;
                    header("Location: base_confirm.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Verbindung+</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/charCount.js"></script>
    </head>
    <body>
        <div id="continer">
            <span id="head">
                <br>
                <h1><img src="../images/header.png"></h1>
                <p><strong>あなただけの公開プロフィールを簡単に作成、共有する。</strong></p>
                <div id="content">
                    <div id="content_inner">
                        <span id="mi"><strong>基本プロフィール情報の編集</strong></span>
                        <span id="inner">
                            <br>
                                基本プロフィール情報の編集を行います。<br>
                                下の入力フォームに編集したい内容を入力し、確定ボタンを押してください。
                        </span>
                        
                            <div>
                                <br>
                                <img src='<?php print("../member/profile_image/".$fetched_m["profile_image"]); ?>' id="img_frame" class="imgleft" width="128" height="128">
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
                            <span id="inner">
                            <p class="ma">
                                    <input type="text" size="50" name="display_name" class="text" placeholder="表示名を入力..." value='<?php if(!is_null($fetched_d["display_name"])){print(htmlspecialchars($fetched_d["display_name"],ENT_QUOTES,"UTF-8"));} ?>' maxlength="36">
                                    <?php if($error["display_name"] == "error"): ?>
                                        <br><font size="4" color="red">*表示名を入力してください</font>
                                    <?php endif; ?>
                                    <input type="text" size="50" name="location_s" class="text" placeholder="居住地を入力..." value='<?php if(!is_null($fetched_m["location"])){print(htmlspecialchars($fetched_m["location"],ENT_QUOTES,"UTF-8"));} ?>' maxlength="36">
                                    <input type="text" size="50" name="work_s" class="text" placeholder='勤務先を入力(120文字)...' value='<?php if(!is_null($fetched_m["works"])){print(htmlspecialchars($fetched_m["works"],ENT_QUOTES,"UTF-8"));} ?>'>
                                    <br><br>
                                    <?php if($error["image"] == "type"): ?>
                                        <font color="red" size="4">*ファイル拡張子はpng、またはjpegを指定してください</font><br>
                                    <?php endif; ?>
                                    <?php if($error["image"] == "anything"): ?>
                                        <font color="red" size="4">*何らかのエラーが発生しました。</font>
                                    <?php endif; ?>
                                    プロフィール画像を編集(png,jpg,jpeg)(128x128px推奨):
                                    <input type="file" name="sel_image" id="image"><br><br>
                            </p><br>
                            <span id="mi">一言コメントの編集</span><br>
                            <script type="text/javascript">
                                $(function() {
                                    $("#comment").charCount({
                                        allowed:120,
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
                                position:absolute;
                                font-size:16px;
                                font-weight:bold;
                                color:#cccccc;
                            }
                            #text_comment .warning { color:#600; }
                            #text_comment .exceeded { color:#e00; }
                            </style>
                            コメントを編集します。制限文字は120文字以内です。<br><br>

                            <span id="text_comment"><textarea id="comment" name="comments"><?php if(!is_null($fetched_m["comment"])){print(htmlspecialchars($fetched_m["comment"],ENT_QUOTES,"UTF-8"));}?></textarea></span><br><br>

                            <?php if($error["comment"]["length"] == "error"): ?>
                                <br><font size="4" color="red">*コメントは120文字以上は登録できません。120文字以下で登録してください</font>
                            <?php endif; ?>
                            </span><br>
                            <span id="mi">クラスタの編集</span><br>
                            <span id="inner">クラスタを編集します。自分の所属していると思ったクラスタを入力してください。<br>
                            </span><br>
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
                            <a href="../settings.php" class="super button blue">　<< 設定画面トップ　</a>
                            <input type="submit" class="super button pink" value="　>> 設定を反映させる　" style="border:0;"><br><br><br><br>
                        </form>
                    </div>
                </div>
            </span>
        </div>
    </body>
</html>