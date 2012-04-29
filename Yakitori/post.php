<?php  
    session_start();
    require("database_connect.php");
    
    if(!isset($_SESSION["username"]) || $_SESSION["username"] != "verbindung_plus")
    {
        header("Location: http://verbindung.me/error.html");
    }
    if(!empty($_POST))
    {
        if($_POST["title"] == "") { $_POST["title"]=="名称未設定"; }
        if($_POST["text_p"] == "") { $_POST["text_p"] == "本文がないですね。はい。"; }
        
        $sql = 'INSERT INTO entry SET title="'.mysql_real_escape_string($_POST["title"]).'",body="'.mysql_real_escape_string($_POST["text_p"]).'",author="'.$_SESSION["username"].'",posted_at=NOW();';
        $sql_r = mysql_query($sql) or die(mysql_error());
        header("Location: done.html");
    }
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>UserCP(post) @ blog.verbindung.me</h1>
        <font size="5">Menu</font><br>
        <a href="edit.php">投稿済み記事の編集</a><br>
        <a href="delete.php">投稿済み記事の削除</a><br>
        <a href="http://verbindung.me/logout.php">Verbindung+からログアウト</a><br>
        <br>
        <font size="5">新規記事の投稿</font>
        <form action="" method="POST">
            <input type="text" size="90" placeholder="タイトル" name="title"><br>
            <textarea rows="30" cols="100" placeholder="本文を入力..." name="text_p"></textarea>
            <br>
            <input type="submit" value="　　　　　投稿　　　　　　">
        </form>
    </body>
</html>