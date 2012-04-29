<?php  
    session_start();
    require("database_connect.php");
    
    if(!isset($_SESSION["username"]) || $_SESSION["username"] != "verbindung_plus")
    {
        header("Location: http://verbindung.me/error.html");
    }
    if(!empty($_POST))
    {
        if($_POST["entry_id"] == "" || !preg_match("/\d+/",$_POST["entry_id"]))
        {
            $error["post"]["entry_id"] = "error";
        }
        if($_POST["title"]  == "") { $_POST["title"] = "名称未設定"; }
        if($_POST["text_p"] == "") { $_POST["text_p"]= "本文がないですね。はい。"; }
        
        mysql_query('UPDATE entry SET title="'.mysql_real_escape_string($_POST["title"]).'",body="'.mysql_real_escape_string($_POST["text_p"]).'",author="'.$_SESSION["username"].'" WHERE entry_id="'.mysql_real_escape_string($_POST["entry_id"]).'";') or die(mysql_error());
        header("Location: done.html");
    }
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>UserCP(edit) @ blog.verbindung.me</h1>
        <font size="5">Menu</font><br>
        <a href="post.php">新規記事の投稿</a><br>
        <a href="delete.php">投稿済み記事の削除</a><br>
        <a href="http://verbindung.me/logout.php">Verbindung+からログアウト</a><br>
        <br>
        <font size="5">投稿済み記事の編集</font>
        <form action="" method="POST">
            <input type="text" size="90" placeholder="記事IDを入力..." name="entry_id"><br>
            <?php if($error["post"]["entry_id"] == "error"): ?>
                <font color="red">投稿番号は必ず入力するか又は、数字で入力する必要があります。</font><br>
            <?php endif; ?>
            <input type="text" size="90" placeholder="タイトル" name="title"><br>
            <textarea rows="30" cols="100" placeholder="本文を入力..." name="text_p"></textarea>
            <br>
            <input type="submit" value="　　　　　編集を終了する　　　　　　">
        </form>
    </body>
</html>