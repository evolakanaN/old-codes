<?php
    function check_screen_name($q){
        if( preg_match('@^([a-z0-9\_]{1,140})$@is',$q) ){
            return true;
        }
        else{
            return false;
        }
    }
    function is_url($text) {
        if(preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $text)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function short($raw){
        $request = file_get_contents("http://ux.nu/api/short?url=".$raw);
        $res = json_decode($request);
        
        return $res->data->url;
    }
    function get_id($screen_name)
    {
        $sql = 'SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($screen_name).'";';
        $res = mysql_query($sql) or die(mysql_error());
        $fetched_id = mysql_fetch_assoc($res);
        
        return $fecthed_id["id"];
    }