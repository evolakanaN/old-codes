<?php
    session_start();
    require("../database_connect.php");
    $un = mysql_query('SELECT COUNT(*) AS ct FROM member_info WHERE screen_name="'.mysql_real_escape_string(htmlspecialchars($_GET["id"],ENT_QUOTES)).'";') or die(mysql_error());;
    $un_t = mysql_fetch_assoc($un);
    if($un_t["ct"] == 0)
    {
        header("Location: http://verbindung.me/error.html");
        exit;
    }
    $fu = mysql_fetch_assoc(mysql_query('SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string(htmlspecialchars($_GET["id"],ENT_QUOTES)).'";'));
    $uid = $fu["id"];
    
    $member_profile = mysql_fetch_assoc(mysql_query('SELECT * FROM member_profile WHERE id="'.mysql_real_escape_string($uid).'";'));
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="http://verbindung.me/css/style.css">
        <script type="text/javascript" src="http://verbindung.me/profile.js"></script>
        <title>Verbindung+<?php print(htmlspecialchars($member_i["display_name"],ENT_QUOTES,"UTF-8")); ?></title>
    </head>
    <body>
        <div id="continer">
            <span id="head">
                <br>
                <h1><a href="http://verbindung.me/"><img src="http://verbindung.me/images/header.png"></a></h1>
                <span id="btn_c">
                    <span id="signup_or_login">
                      
                            <a href='http://verbindung.me/id/<?php print(htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8")); ?>' class='medium button green'>　+この人のプロフィールへ　</a>
                        
                    </span>
                </span>
                <p><strong>あなただけの公開プロフィールを簡単に作成、共有する。</strong></p>
            </span>
            <div id="content">
                <div id="content_inner">
                       <span id="inner">
                        <br>
                            <?php
                                $sq_t = 'SELECT tag FROM other_user_tags WHERE id="'.mysql_real_escape_string($uid).'";';
                                $sq_st = mysql_query($sq_t) or die(mysql_error());
                                
                                while($data_t = mysql_fetch_assoc($sq_st))
                                {
                                    if($data_t["tag"] != "")
                                    {
                                        $out_tag = '<img src="http://verbindung.me/images/16/button-white.png" width="16" height="16"> <a href="">'.htmlspecialchars($data_t["tag"]).'</a>　';
                                        print($out_tag);
                                    }
                                    else
                                    {
                                        print("");
                                    }
                                }
                                $sq_cnt = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS cnt_t FROM user_comments WHERE to_id="'.mysql_real_escape_string($uid).'";'));
                            ?>
                            <br><br>
                            ( <img src="http://verbindung.me/images/16/add.png" width="13" height="13"><a href='<?php if(!isset($_SESSION["username"])){print("http://verbindung.me/login.php?redirect=".htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8"));}else{print("http://verbindung.me/friend/tag.php?id=".htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8"));} ?>'> タグを編集</a> )
                        <br>
                        </span>
                        <br>
                        <span id="inner">
                            <span id="mi">Comments(<?php print(htmlspecialchars($sq_cnt["cnt_t"])); ?>)</span><br>
                        
                            <?php
                                function get_profile_image_url($self_i)
                                {
                                    $s28 = mysql_fetch_assoc(mysql_query('SELECT profile_image FROM member_profile WHERE id="'.mysql_real_escape_string($self_i).'";'));
                                    return $s28["profile_image"];
                                }
                                function get_screen_name($id)
                                {
                                    $s29 = mysql_fetch_assoc(mysql_query('SELECT screen_name FROM member_info WHERE id="'.mysql_real_escape_string($id).'";'));
                                    return $s29["screen_name"];
                                }
                                function get_display_name($id)
                                {
                                    $s30 = mysql_fetch_assoc(mysql_query('SELECT display_name FROM member_info WHERE id="'.mysql_real_escape_string($id).'";'));
                                    return $s30["display_name"];
                                }
                                $page = htmlspecialchars($_GET["page"]);
                                if($page == "")
                                {
                                    $page = 1;
                                }
                                $page = max($page,1);
                                $sql_ct = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS ct FROM user_comments'));
                                $max_p = ceil($sql_ct["ct"] / 5);
                                $page = min($page, $max_p);
                                
                                $start_pos = ($page -1) *5;
                                if($start_pos == -5 ) { $start_pos = 0; }
                                
                                $sql_info = 'SELECT * FROM user_comments WHERE to_id="'.mysql_real_escape_string($uid).'" ORDER BY comment_id DESC LIMIT '.$start_pos.',5;';
                                $res_info = mysql_query($sql_info) or die(mysql_error());
                                while($data_i = @mysql_fetch_assoc($res_info))
                                {
                                    $output_c = '';
                                    $output_c .= '<div>';
                                    $output_c .= '<img src="http://img.verbindung.me/'.htmlspecialchars(get_profile_image_url($data_i["self_id"]),ENT_QUOTES,"UTF-8").'" id="img_frame" class="imgleft" width="88" height="88">';
                                    $output_c .= '</div>';
                                    $output_c .= '<p class="ma" id="description_background">';
                                    $output_c .= '  <img src="http://verbindung.me/images/name.png" width="16" height="16"> <strong>投稿者:</strong> <a href="http://verbindung.me/id/'.htmlspecialchars(get_screen_name($data_i["self_id"]),ENT_QUOTES,"UTF-8").'">'.htmlspecialchars(get_display_name($data_i["self_id"]),ENT_QUOTES,"UTF-8").'</a>';
                                    $output_c .= '　<br>';
                                    $output_c .= '  <img src="http://verbindung.me/images/description.png" width="16" height="16"> <strong>コメント:</strong> '.htmlspecialchars($data_i["comment_text"],ENT_QUOTES,"UTF-8").'';
                                    $output_c .= '</p>';
                                    $output_c .= '<br>';
                                    
                                    print($output_c);
                                }
                            ?>
                            <br>
                            <br>
                            <center>
                            <?php
                                if($page > 1) {
                            ?>
                                <a href="friend.php?id=<?php print(htmlspecialchars($_GET['id'],ENT_QUOTES,'UTF-8').'&page='.($page-1)); ?>" class="super button blue">　<< 前ページ　</a>
                            <?php }else { ?>
                                <a href="" class="super button blue">　<< ありません　</a>
                            <?php } ?>
                            <a href="<?php if(!isset($_SESSION['username'])){print('http://verbindung.me/login.php?redirect='.htmlspecialchars($_GET['id'],ENT_QUOTES,'UTF-8'));}else{print('http://verbindung.me/friend/post_comment.php?id='.htmlspecialchars($_GET['id'],ENT_QUOTES,'UTF-8'));} ?>" style="border:0;" class="super button green">　書込　</a>  
                            <?php if($page < $max_p) { ?>
                                <a href="friend.php?id=<?php print(htmlspecialchars($_GET['id'],ENT_QUOTES,'UTF-8').'&page='.($page+1)); ?>" class="super button pink">　>> 次ページ　</a>
                            <?php } else { ?>
                                <a href="" class="super button pink">　>> ありません　</a>
                            <?php } ?>
                            </center>
                        </span>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </body>
</html>