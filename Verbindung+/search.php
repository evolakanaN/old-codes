<?php
    session_start();
    require("database_connect.php");
    $query = htmlspecialchars($_GET["tag"],ENT_QUOTES,"UTF-8");
    if($query == "")
    {
        header("Location: http://verbindung.me/error.html");
    }
    $t1 = mysql_query('SELECT COUNT(id) AS ct FROM user_tags WHERE tag LIKE "%'.mysql_real_escape_string($query).'%"') or die(mysql_error());
    $fetched_t1 = mysql_fetch_assoc($t1);
    function get_display_name($id)
    {
        $sql = mysql_query('SELECT display_name FROM member_info WHERE id="'.mysql_real_escape_string($id).'";')or die(mysql_error());
        $res = mysql_fetch_assoc($sql);
        
        return $res["display_name"];
    }
    function get_screen_name($id)
    {
        $sq23 = mysql_query('SELECT screen_name FROM member_info WHERE id="'.mysql_real_escape_string($id).'";');
        $res_23 = mysql_fetch_assoc($sq23);
        
        return $res_23["screen_name"];
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Verbindung+</title>
        <link rel="stylesheet" type="text/css" href="http://verbindung.me/css/style.css">
    </head>
    <body>
        <div id="continer">
            <span id="head">
                <br>
                <a href="http://verbindung.me/"><img src="http://verbindung.me/images/header.png"></a>
                <p><strong>あなただけの公開プロフィールを簡単に作成、共有する</strong></p>
            </span>
                <div id="content">
                    <div id="content_inner">
                        <span id="mi"><strong>Verbindung+クラスタ検索</strong></span><br>
                        <span id="inner">
                                クラスタ<strong>'<?php print(htmlspecialchars($_GET["tag"],ENT_QUOTES,"UTF-8")); ?>'</strong>での検索結果(前方+後方一致検索)<strong><?php print(htmlspecialchars($fetched_t1["ct"],ENT_QUOTES,"UTF-8")); ?>件</strong><br>
                                <br>
                                <?php
                                    $page = htmlspecialchars($_GET["page"],ENT_QUOTES,"UTF-8");
                                    if($page == "")
                                    { 
                                        $page = 1;
                                    }
                                    $page = max($page,1);
                                    $max_p = ceil($fetched_t1["ct"]/5);
                                    $page = min($page, $max_p);
                                    $start_pos = ($page - 1)*5;
                                    
                                    $sq = 'SELECT * from user_tags left join member_profile on user_tags.id=member_profile.id where user_tags.tag LIKE "%'.mysql_real_escape_string(urldecode($query)).'%" group by member_profile.id ORDER BY member_profile.id DESC LIMIT '.mysql_real_escape_string($start_pos).',5;';

                                $sq_res = mysql_query($sq);
                                while($data = @mysql_fetch_assoc($sq_res))
                                {
                                    $output = '';
                                    $output .= '<div>';
                                    $output .= '    <img src="http://img.verbindung.me/'.htmlspecialchars($data["profile_image"],ENT_QUOTES,"UTF-8").'" id="img_frame" class="imgleft" width="128" height="128">';
                                    $output .= '</div>';
                                    $screen_name = get_screen_name($data["id"]);
                                    $output .= '<p class="ma" id="description_background">';
                                    $output .= '    <img src="images/name.png" width="16" height="16"> <strong>名前:</strong> <a href="http://verbindung.me/id/'.htmlspecialchars($screen_name,ENT_QUOTES,"UTF-8").'">'.htmlspecialchars(get_display_name($data["id"]),ENT_QUOTES,"UTF-8").'</a><br>';
                                    $output .= '    <img src="images/home.png" width="16" height="16"> <strong>居住地:</strong> '.htmlspecialchars($data["location"],ENT_QUOTES,"UTF-8").'<br>';
                                    $output .= '    <img src="images/work.png" width="16" height="16"> <strong>勤務先:</strong> '.htmlspecialchars($data["works"],ENT_QUOTES,"UTF-8").'<br>';
                                    $output .= '    <img src="images/description.png" width="16" height="16"> <strong>一言コメント:</strong> '.htmlspecialchars($data["comment"],ENT_QUOTES,"UTF-8").'<br><br><br>';
                
                                    
                                    print($output);
                                }
                                ?><div align="center"><br>
                                <?php
                                    if($page > 1) {
                                ?>
                                    <a href="search.php?tag=<?php print $query.'&page='.($page-1) ?>" class="super button blue" style="border:0;">　<< 前のページへ　</a>
                                <?php }else{ ?>
                                <?php } ?>
                                <?php
                                    if($page < $max_p)
                                    {
                                ?>
                                    <a href="search.php?tag=<?php print $query.'&page='.($page+1); ?>" class="super button pink" style="border:0;">　>> 次のページへ　</a>
                                <?php
                                    } else {
                                ?>
                                <?php } ?></div>
            
                            <br><br>
                        </span>
                    </div>
                </div>
            </span>
        </div>
    </body>
</html>