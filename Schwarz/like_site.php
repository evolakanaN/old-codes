<?php
    session_start();
    require("database_connect.php");
    
    if(!isset($_SESSION["user_id"])) {
        return false;
    }
    if(!empty($_POST) && isset($_SESSION["ticket"])) {
        $id = htmlspecialchars($_POST["id"]);
        $s_num = htmlspecialchars($_POST[""]);
        
        $s1 = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS FROM like_site WHERE member_id="'.mysql_real_escape_string($id).'" AND site_id="'.mysql_real_escape_string($s_num).'";'));
    }