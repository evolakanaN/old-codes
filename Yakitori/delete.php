<?php  
    session_start();
    require("database_connect.php");
    
    if(!isset($_SESSION["username"]) || $_SESSION["username"] != "verbindung_plus")
    {
        header("Location: http://verbindung.me/error.html");
    }
    if(!empty($_POST))
    {
        if($_POST["del_id"] == "" || !preg_match("/\d+/",$_POST["del_id"]))
        {   
            $error["delete"]["id"] = "error";
        }
        
        $sql = 'DELETE FROM entry WHERE entry_id="'.mysql_real_escape_string($_POST["del_id"]).'";';
        $sql_r = mysql_query($sql) or die(mysql_error());
        header("Location: done.html");
    }
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>UserCP(delete) @ blog.verbindung.me</h1>
        <font size="5">Menu</font><br>
        <a href="edit.php">新規記事の投稿</a><br>
        <a href="delete.php">投稿済み記事の編集</a><br>
        <a href="http://verbindung.me/logout.php">Verbindung+からログアウト</a><br>
        <br>
        <font size="5">投稿済み記事の削除</font>
        <form action="" method="POST">
            <input type="text" size="90" placeholder="削除する投稿IDを入力..." name="del_id"><br>
            <?php if($error["delete"]["id"] == "error"): ?>
                <font color="red">投稿IDが入力されていない、または数字ではない可能性があります</font>
            <?php endif; ?>
            <br>
            <input type="submit" value="　　　　　削除　　　　　　">
        </form>
    </body>
</html>