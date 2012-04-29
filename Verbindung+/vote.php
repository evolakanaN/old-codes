<?php
    mysql_connect("localhost","","") or die(mysql_error());
    mysql_select_db("");
    mysql_query("SET NAMES UTF-8");
    
    $q = htmlspecialchars($_POST["id"],ENT_QUOTES,"UTF-8");
    $ip_sql = mysql_query('SELECT ip FROM vote WHERE screen_name="'.mysql_real_escape_string($q).'";');
    $fetched_ip = mysql_fetch_assoc($ip_sql);
    if($fetched_ip["ip"] != ip2long($_SERVER["REMOTE_ADDR"]))
    {  
        mysql_query('UPDATE vote SET vote_count=vote_count+1,ip="'.ip2long($_SERVER["REMOTE_ADDR"]).'" WHERE screen_name="'.mysql_real_escape_string($q).'";');
    
        $r = 'SELECT vote_count FROM vote WHERE screen_name="'.mysql_real_escape_string($q).'";';
        $re = mysql_query($r) or die(mysql_error());
        $p = mysql_fetch_assoc($re);
        header("Access-Control-Allow-Origin: http://verbindung.me/");
        print($p["vote_count"]);
    }
    else
    {
        header("HTTP",true,403);
    }