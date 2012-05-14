<?php
    session_start();
    require("database_connect.php");

    if(!isset($_SESSION["user_id"])) {
        header("Location: http://verbindung.me/schwarz/");
        exit;
    }
    $flag = 0;
    $q_s = htmlspecialchars($_GET["w"],ENT_QUOTES,"UTF-8");
    $q_id = $_SESSION["user_id"];
    $q_type = htmlspecialchars($_GET["type"],ENT_QUOTES,"UTF-8");
    $page = htmlspecialchars($_GET["page"],ENT_QUOTES,"UTF-8");
    
    if($q_id == "") {
        $flag = 1;
    }
    if($_GET["page"] == "") {
        $page = 1;
    }
    if($_GET["type"] == "") {
        $q_type = "normal";
    }
    if($_GET["type"] == "" || $_GET["type"] == "b") {
        $s0 = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS xttt FROM member_status WHERE member_id="'.mysql_real_escape_string($q_id).'" AND title collate utf8_unicode_ci LIKE "%'.mysql_real_escape_string($q_s).'%";'));
    }else if($_GET["type"] =="u") {
        $s0 = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS xttt FROM member_info WHERE screen_name collate utf8_unicode_ci LIKE "%'.mysql_real_escape_string($q_s).'%";'));
    } else if($_GET["type"] == "t") {
        $s0 = mysql_fetch_assoc(mysql_query('SELECT COUNT(DISTINCT status_tag.tag) AS xttt FROM status_tag WHERE status_tag.tag collate utf8_unicode_ci LIKE "%'.mysql_real_escape_string($q_s).'%";'));
    }
    $max_p = ceil($s0["xttt"]/5);
    $page = min($page,$max_p);
    $start = ($page - 1) * 30;
    if($_GET["type"] == "" || $_GET["type"] == "normal") {
        //ブックマーク検索用
        $s1 = mysql_query('SELECT * FROM member_status WHERE member_id="'.mysql_real_escape_string($q_id).'" AND title  collate utf8_unicode_ci LIKE "%'.mysql_real_escape_string($q_s).'%" ORDER BY timestamp DESC LIMIT 0,5;');
        $ss1 = mysql_fetch_assoc(mysql_query('SELECT COUNT(title) AS xt FROM member_status WHERE member_id="'.mysql_real_escape_string($q_id).'" AND title collate utf8_unicode_ci LIKE "%'.mysql_real_escape_string($q_s).'%" ORDER BY timestamp DESC LIMIT 0,5;'));
        //ユーザー検索用
        $s2 = mysql_query('SELECT * FROM member_info WHERE screen_name collate utf8_unicode_ci LIKE "%'.mysql_real_escape_string($q_s).'%" ORDER BY timestamp DESC LIMIT 0,5;');
        //タグ検索結果用
        $s3 = mysql_query('SELECT DISTINCT status_tag.tag,status_tag.member_id,COUNT(status_tag.site_url) AS xt FROM status_tag WHERE status_tag.tag collate utf8_unicode_ci LIKE "%'.mysql_real_escape_string($q_s).'%" GROUP BY status_tag.tag ORDER BY xt DESC LIMIT 0,5;');
    }
    if($_GET["type"] == "b") {
    $ss1 = mysql_query('SELECT * FROM member_status WHERE member_id="'.mysql_real_escape_string($q_id).'" AND title collate utf8_unicode_ci LIKE "%'.mysql_real_escape_string($q_s).'%" ORDER BY timestamp DESC LIMIT '.$start.',30;');
    }
    if($_GET["type"] == "u") {
        $ss2 = mysql_query('SELECT * FROM member_info WHERE screen_name collate utf8_unicode_ci LIKE "%'.mysql_real_escape_string($q_s).'%" ORDER BY timestamp DESC LIMIT '.$start.',30;');
    }
    if($_GET["type"] == "t") {
        $ss3 = mysql_query('SELECT DISTINCT status_tag.tag,status_tag.member_id,COUNT(status_tag.site_url) AS xt FROM status_tag WHERE status_tag.tag collate utf8_unicode_ci LIKE "%'.mysql_real_escape_string($q_s).'%" GROUP BY status_tag.tag ORDER BY xt DESC LIMIT '.$start.',30');
    }
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Schwarz</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div id="line_a">
            <span style="float:right;color:#ffffff;margin-right:50px;font-size:0.8em;margin-top:8px;opacity:0.5;"><a href="">トップ</a> | <a href="">新着エントリ</a> | <a href="">アカウント設定</a> | <strong><a href="">ログアウト</a></strong>
            </span>
        </div>
        <div id="header">
            <div id="he" style="margin:0;width:940px;margin-left:auto;margin-right:auto;">
            <img src="images/header.png" style="margin-left:50px;margin-left:auto;margin-right:auto;float:left;"width="300" height="100">
            <div id="float:right;">
            <input type="text" id="nttn" class="search_text" placeholder="ユーザー,ブックマーク,タグ">
            <input type="submit" id="nttnp" class="search_button" value="検索">
            <script type="text/javascript">
                document.getElementById("nttnp").onclick = function() {
                    var e = document.getElementById("nttn").value;
                    location.href = "s_search.php?w="+e;
                };
            </script>
            </div>
            </div>
        </div>
        <div id="content">
                <p class="blank"></p>
                    <div style="float:right;">
                        <span style="color:#615555;font-size:1.2em;">メニュー</span>
                        　  <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                        　 <button class="btn primary" onClick="location.href='s_search.php?w=<?php print(htmlspecialchars($_GET['w'])); ?>&type=b';" style="width:190px;">ブックマークのみ表示</button><br>
                        　  <button class="btn info" onClick="location.href='s_search.php?w=<?php print(htmlspecialchars($_GET['w'])); ?>&type=u';" style="width:190px;">ユーザーのみ表示</button><br>
                        　  <button class="btn info" onClick="location.href='s_search.php?w=<?php print(htmlspecialchars($_GET['w'])); ?>&type=t';" style="width:190px;">タグのみ表示</button><br>
                            <br>
                        　 <button class="btn" style="width:190px;margin-top:5px;">ユーザーページへ</button><br>
                     　  <button class="btn" style="width:190px;">まとめタグ</button><br>
                     　  <button class="btn" style="width:190px;">閲覧した動画</button><br>
                     　  <button class="btn" style="width:190px;">閲覧した画像</button><br>
                     　 <br>
                    <span style="color:#615555;font-size:1.2em;">広告</span>
                    <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                    </div>
                    <span style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">Schwarz検索</span>
                    <?php if($q_type == "normal"): ?>
                    <p style="width:650px;height:20px;margin-top:0;background-color:#e4e4e4;border-radius:0px;border-top:#c6c6c6 2px solid;font-size:0.8em;padding-left:10px;">ブックマーク検索結果</p>
                    <ul style="padding:0;padding-left:10px;">
                        <?php
                            $output = "";
                            while($data_b = mysql_fetch_assoc($s1)) 
                            {
                                $b2 = mysql_fetch_assoc(mysql_query('SELECT type,site_id FROM site_directory WHERE site_url="'.mysql_real_escape_string($data_b["site_url"]).'";'));

                                if($b2["type"] == 0) {
                                    $type_img = "images/s.png";
                                }
                                else if($b2["type"] == 2) {
                                    $type_img = "images/douga.png";
                                }
                                else if($b2["type"] == 3) {
                                    $type_img = "images/photo.png";
                                }
                                $output .= '<img src="'.htmlspecialchars($type_img).'" class="imgleft">';
                                $output .= '<a href="site.php?id='.htmlspecialchars($b2["site_id"]).'" style="text-decoration:none;font-color:#615555;margin:0;"><p style="margin:0;color:#615555;font-weight:bold;font-size:0.9em;">'.mb_strimwidth(htmlspecialchars($data_b["title"]),0,70,"...","utf8").'"</p></a>';
                                $output .= '<p style="margin:0;color:#009933;font-size:0.7em;">'.htmlspecialchars($data_b["site_url"]).'</a>';
                                $output .= '<p style="margin-top:20px;"></p>';
                            }
                            print($output);
                        ?>
                    </ul>
                    <p style="width:650px;height:20px;margin:0;margin-top:0;background-color:#e4e4e4;border-radius:0px;border-top:#c6c6c6 2px solid;font-size:0.8em;padding-left:10px;">ユーザー検索結果</p>
                    <ul style="padding:0;padding-left:10px;">
                        <?php
                            $output_u = "";
                            while($data_u = mysql_fetch_assoc($s2))
                            {
                                $s22 = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS xtt FROM member_status WHERE member_id="'.mysql_real_escape_string($data_u["id"]).'";'));
                                $s223 = mysql_fetch_assoc(mysql_query('SELECT profile_image_url FROM profile_image WHERE id="'.mysql_real_escape_string($data_u["id"]).'";'));

                                $output_u .= '<img src="'.htmlspecialchars($s223["profile_image_url"]).'" style="border-radius:5px;" class="imgleft" width="52" height="52">';
                                $output_u .= '<a href="user.php?id='.htmlspecialchars($data_u["id"]).'" style="text-decoration:none;"><span style="color:#615555;font-weight:bold;font-size:1.2em;">@'.htmlspecialchars($data_u["screen_name"]).'</span></a>';
                                $output_u .= '<p style="margin:0;margin-top:4px;"></p>';
                                $output_u .= '<span style="padding:0;margin:0;border-radius:3px;background-color:#ebebeb;padding-left:3px;padding-right:4px;padding-bottom:1px;border:#bbbbbb 1px solid;">';
                                $output_u .= '<img src="images/fav.png" style="margin-left:0px;margin-top:4px;" width="10" height="10"><span style="margin:0;margin-left:4px;font-size:0.7em;color:gray">'.htmlspecialchars($s22["xtt"]).'件のブックマーク</span></span><span style="padding-left:5px;"></span><span style="padding:0;margin:0;border-radius:3px;background-color:#ebebeb;padding-left:3px;padding-right:4px;padding-bottom:1px;border:#bbbbbb 1px solid;"><img src="images/follower.png" style="margin-top:4px;" width="10" height="10"><span style="margin:0;margin-left:4px;font-size:0.7em;color:gray">223フォロワー / 32人をフォロー中</span></span>';
                                $output_u .= '<p style="margin-top:25px;"></p>';
                               
                            }
                            print($output_u);
                        ?>
                    </ul>
                    <p style="width:650px;height:20px;margin-top:0;background-color:#e4e4e4;border-radius:0px;border-top:#c6c6c6 2px solid;font-size:0.8em;padding-left:10px;">タグ検索結果</p>
                    <ul style="padding:0;padding-left:10px;">
                        <?php
                            $output_t = "";
                            while($data_t = mysql_fetch_assoc($s3))
                            {
                                $s33 = mysql_fetch_assoc(mysql_query('SELECT profile_image_url FROM profile_image WHERE id="'.mysql_real_escape_string($data_t["member_id"]).'";'));
                                $screen_s33 = mysql_fetch_assoc(mysql_query('SELECT screen_name FROM member_info WHERE id="'.mysql_real_escape_string($data_t["member_id"]).'";'));
                                    
                                $output_t .= '<img src="'.htmlspecialchars($s33["profile_image_url"]).'" class="imgleft" style="border-radius:5px;" width="52" height="52">';
                                $output_t .= '<span style="font-size:1.2em;font-weight:bold;"><a href="tag_v.php?id='.htmlspecialchars($data_t["member_id"]).'&tag='.htmlspecialchars($data_t["tag"]).'" style="text-decoration:none;color:#615555;">'.htmlspecialchars($data_t["tag"]).'</a></span>';
                                $output_t .= '<span style="color:gray;"> ('.htmlspecialchars($data_t["xt"]).')</span>';
                                $output_t .= '<br>';
                                $output_t .= '<span style="font-size:0.7em;color:gray;">作成者: <a href="user.php?id='.htmlspecialchars($data_t["member_id"]).'" style="text-decoration:none;color:gray;">@'.htmlspecialchars($screen_s33["screen_name"]).'</a></span>';
                                $output_t .= '<p style="margin:0;margin-top:4px;"></p>';
                                $output_t .= '<span style="padding:0;margin:0;border-radius:3px;background-color:#ebebeb;padding-left:3px;padding-right:4px;padding-bottom:1px;border:#bbbbbb 1px solid;">';
                                $output_t .= '<img src="images/fav.png" style="margin-left:0px;margin-top:4px;" width="10" height="10"><span style="margin:0;margin-left:4px;font-size:0.7em;color:gray">44 人がブックマーク</span>';
                                $output_t .= '</span>';
                                $output_t .= '<span style="padding:0;margin:0;border-radius:3px;background-color:#ebebeb;padding-left:3px;padding-right:4px;padding-bottom:1px;border:#bbbbbb 1px solid;">';
                                $output_t .= '<img src="images/follower.png" style="margin-top:4px;" width="10" height="10"><span style="margin:0;margin-left:4px;font-size:0.7em;color:gray">293人がいいね!と言っています</span>';
                                $output_t .= '</span><p style="margin-top:20px;"></p>';
                            }
                            print($output_t);
                        ?>
                        </ul>
                        <br>
                    <?php endif; ?>
                    <?php if($q_type == "b"): ?>
                    <p style="width:650px;height:20px;margin-top:0;background-color:#e4e4e4;border-radius:0px;border-top:#c6c6c6 2px solid;font-size:0.8em;padding-left:10px;">ブックマーク検索結果</p>
                    <ul style="padding:0;padding-left:10px;">
                    <?php
                    $output = "";
                        while($data_b = mysql_fetch_assoc($ss1)) 
                        {
                            $b2 = mysql_fetch_assoc(mysql_query('SELECT type,site_id FROM site_directory WHERE site_url="'.mysql_real_escape_string($data_b["site_url"]).'";'));

                            if($b2["type"] == 0) {
                                $type_img = "images/s.png";
                            }
                            else if($b2["type"] == 2) {
                                $type_img = "images/douga.png";
                            }
                            else if($b2["type"] == 3) {
                                $type_img = "images/photo.png";
                            }
                            $output .= '<img src="'.htmlspecialchars($type_img).'" class="imgleft">';
                            $output .= '<a href="site.php?id='.htmlspecialchars($b2["site_id"]).'" style="text-decoration:none;font-color:#615555;margin:0;"><p style="margin:0;color:#615555;font-weight:bold;font-size:0.9em;">'.mb_strimwidth(htmlspecialchars($data_b["title"]),0,70,"...","utf8").'"</p></a>';
                            $output .= '<p style="margin:0;color:#009933;font-size:0.7em;">'.htmlspecialchars($data_b["site_url"]).'</a>';
                            $output .= '<p style="margin-top:20px;"></p>';
                            
                        }
                        print($output);
                    ?>
                    <div id="paging" style="width:630px;">
                    <?php if($page > 1) { ?>
                                <p style="margin:0;float:left;">
                                    <a href="s_search.php?w=<?php print(htmlspecialchars($_GET['w'])) ?>&id=<?php print(htmlspecialchars($_GET['id'])) ?>&page=<?php print($page-1); ?><?php if($q_type == 'normal'){print('');}else if($_GET['type'] == 'b'){print('&type=b');} ?>">前のページへ</a>
                                </p>
                            <?php } else { ?>
                                <p style="margin:0;float:left;">
                                    前のページへ
                                </p>
                            <?php } ?>
                            <?php if($page < $max_p) { ?>
                                 <p style="margin:0;float:right;">
                                    <a href="s_search.php?w=<?php print(htmlspecialchars($_GET['w'])) ?>&id=<?php print(htmlspecialchars($_GET['id'])) ?>&page=<?php print($page+1); ?><?php if($q_type == 'normal'){print('');}else if($_GET['type'] == 'b'){print('&type=b');} ?>">次のページへ</a>
                                </p>
                            <?php } else { ?>
                                 <p style="margin:0;float:left;">
                                    次のページ
                                </p>
                            <?php } ?>
                            <br>
                    </div>
                    <?php endif; ?>
                    <?php if($_GET["type"] == "u"): ?>
                    <p style="width:650px;height:20px;margin-top:0;background-color:#e4e4e4;border-radius:0px;border-top:#c6c6c6 2px solid;font-size:0.8em;padding-left:10px;">ユーザー検索結果</p>
                    <ul style="padding:0;padding-left:10px;">
                    <?php
                        $output_u = "";
                            while($data_u = mysql_fetch_assoc($ss2))
                            {
                                $s22 = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS xtt FROM member_status WHERE member_id="'.mysql_real_escape_string($data_u["id"]).'";'));
                                $s223 = mysql_fetch_assoc(mysql_query('SELECT profile_image_url FROM profile_image WHERE id="'.mysql_real_escape_string($data_u["id"]).'";'));

                                $output_u .= '<img src="'.htmlspecialchars($s223["profile_image_url"]).'" style="border-radius:5px;" class="imgleft" width="52" height="52">';
                                $output_u .= '<a href="user.php?id='.htmlspecialchars($data_u["id"]).'" style="text-decoration:none;"><span style="color:#615555;font-weight:bold;font-size:1.2em;">@'.htmlspecialchars($data_u["screen_name"]).'</span></a>';
                                $output_u .= '<p style="margin:0;margin-top:4px;"></p>';
                                $output_u .= '<span style="padding:0;margin:0;border-radius:3px;background-color:#ebebeb;padding-left:3px;padding-right:4px;padding-bottom:1px;border:#bbbbbb 1px solid;">';
                                $output_u .= '<img src="images/fav.png" style="margin-left:0px;margin-top:4px;" width="10" height="10"><span style="margin:0;margin-left:4px;font-size:0.7em;color:gray">'.htmlspecialchars($s22["xtt"]).'件のブックマーク</span></span><span style="padding-left:5px;"></span><span style="padding:0;margin:0;border-radius:3px;background-color:#ebebeb;padding-left:3px;padding-right:4px;padding-bottom:1px;border:#bbbbbb 1px solid;"><img src="images/follower.png" style="margin-top:4px;" width="10" height="10"><span style="margin:0;margin-left:4px;font-size:0.7em;color:gray">223フォロワー / 32人をフォロー中</span></span>';
                                $output_u .= '<p style="margin-top:25px;"></p>';
                            }
                            print($output_u);
                    ?>
                    <div id="paging" style="width:630px;">
                    <?php if($page > 1) { ?>
                                <p style="margin:0;float:left;">
                                    <a href="s_search.php?w=<?php print(htmlspecialchars($_GET['w'])) ?>&id=<?php print(htmlspecialchars($_GET['id'])) ?>&page=<?php print($page-1); ?><?php if($q_type == 'normal'){print('');}else if($_GET['type'] == 'u'){print('&type=u');} ?>">前のページへ</a>
                                </p>
                            <?php } else { ?>
                                <p style="margin:0;float:left;">
                                    前のページへ
                                </p>
                            <?php } ?>
                            <?php if($page < $max_p) { ?>
                                 <p style="margin:0;float:right;">
                                    <a href="s_search.php?w=<?php print(htmlspecialchars($_GET['w'])) ?>&id=<?php print(htmlspecialchars($_GET['id'])) ?>&page=<?php print($page+1); ?><?php if($q_type == 'normal'){print('');}else if($_GET['type'] == 'u'){print('&type=u');} ?>">次のページへ</a>
                                </p>
                            <?php } else { ?>
                                 <p style="margin:0;float:left;">
                                    次のページ
                                </p>
                            <?php } ?>
                            <br>
                    </div>
                    <?php endif; ?>
                    <?php if($_GET["type"] == "t"): ?>
                    <p style="width:650px;height:20px;margin-top:0;background-color:#e4e4e4;border-radius:0px;border-top:#c6c6c6 2px solid;font-size:0.8em;padding-left:10px;">ユーザー検索結果</p>
                    <ul style="padding:0;padding-left:10px;">
                    <?php
                        $output_t = "";
                            while($data_t = mysql_fetch_assoc($ss3))
                            {
                                $s33 = mysql_fetch_assoc(mysql_query('SELECT profile_image_url FROM profile_image WHERE id="'.mysql_real_escape_string($data_t["member_id"]).'";'));
                                $screen_s33 = mysql_fetch_assoc(mysql_query('SELECT screen_name FROM member_info WHERE id="'.mysql_real_escape_string($data_t["member_id"]).'";'));
                                    
                                $output_t .= '<img src="'.htmlspecialchars($s33["profile_image_url"]).'" class="imgleft" style="border-radius:5px;" width="52" height="52">';
                                $output_t .= '<span style="font-size:1.2em;font-weight:bold;"><a href="tag_v.php?id='.htmlspecialchars($data_t["member_id"]).'&tag='.htmlspecialchars($data_t["tag"]).'" style="text-decoration:none;color:#615555;">'.htmlspecialchars($data_t["tag"]).'</a></span>';
                                $output_t .= '<span style="color:gray;"> ('.htmlspecialchars($data_t["xt"]).')</span>';
                                $output_t .= '<br>';
                                $output_t .= '<span style="font-size:0.7em;color:gray;">作成者: <a href="user.php?id='.htmlspecialchars($data_t["member_id"]).'" style="text-decoration:none;color:gray;">@'.htmlspecialchars($screen_s33["screen_name"]).'</a></span>';
                                $output_t .= '<p style="margin:0;margin-top:4px;"></p>';
                                $output_t .= '<span style="padding:0;margin:0;border-radius:3px;background-color:#ebebeb;padding-left:3px;padding-right:4px;padding-bottom:1px;border:#bbbbbb 1px solid;">';
                                $output_t .= '<img src="images/fav.png" style="margin-left:0px;margin-top:4px;" width="10" height="10"><span style="margin:0;margin-left:4px;font-size:0.7em;color:gray">44 人がブックマーク</span>';
                                $output_t .= '</span>';
                                $output_t .= '<span style="padding:0;margin:0;border-radius:3px;background-color:#ebebeb;padding-left:3px;padding-right:4px;padding-bottom:1px;border:#bbbbbb 1px solid;">';
                                $output_t .= '<img src="images/follower.png" style="margin-top:4px;" width="10" height="10"><span style="margin:0;margin-left:4px;font-size:0.7em;color:gray">293人がいいね!と言っています</span>';
                                $output_t .= '</span><p style="margin-top:20px;"></p>';
                            }
                            print($output_t);
                    ?>
                    <div id="paging" style="width:630px;">
                    <?php if($page > 1) { ?>
                                <p style="margin:0;float:left;">
                                    <a href="s_search.php?w=<?php print(htmlspecialchars($_GET['w'])) ?>&id=<?php print(htmlspecialchars($_GET['id'])) ?>&page=<?php print($page-1); ?><?php if($q_type == 'normal'){print('');}else if($_GET['type'] == 't'){print('&type=t');} ?>">前のページへ</a>
                                </p>
                            <?php } else { ?>
                                <p style="margin:0;float:left;">
                                    前のページへ
                                </p>
                            <?php } ?>
                            <?php if($page < $max_p) { ?>
                                 <p style="margin:0;float:right;">
                                    <a href="s_search.php?w=<?php print(htmlspecialchars($_GET['w'])) ?>&id=<?php print(htmlspecialchars($_GET['id'])) ?>&page=<?php print($page+1); ?><?php if($q_type == 'normal'){print('');}else if($_GET['type'] == 't'){print('&type=t');} ?>">次のページへ</a>
                                </p>
                            <?php } else { ?>
                                 <p style="margin:0;float:left;">
                                    次のページ
                                </p>
                            <?php } ?>
                            <br>
                    </div>
                    <?php endif; ?>
           <p class="blank"></p>
        </div>
        <div id="footer">
        </div>
    </body>
</html>
