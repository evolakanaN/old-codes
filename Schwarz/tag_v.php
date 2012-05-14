<?php
    session_start();
    require("database_connect.php");

    $q_id = htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
    $q_tag = htmlspecialchars($_GET["tag"],ENT_QUOTES,"UTF-8");
    $q_status = htmlspecialchars($_GET["s"],ENT_QUOTES,"UTF-8");

    function convert($scr){
        $sn = mysql_fetch_assoc(mysql_query('SELECT id FROM member_info WHERE id="'.mysql_real_escape_string($scr).'";'));
        return $sn["id"];
    }
    $page = $_GET["page"];
    if($_GET["page"] == "") {
        $page = 1;
    }
    function getSiteId($site_urls) {
        $ssntt = mysql_fetch_assoc(mysql_query('SELECT site_id FROM site_directory WHERE site_url="'.mysql_real_escape_string($site_urls).'";'));
        return $ssntt["site_id"];
    }
    $page = max($page,1);
    $nst = mysql_fetch_assoc(mysql_query('SELECT COUNT(tag) AS xt FROM status_tag WHERE member_id="'.mysql_real_escape_string($q_id).'" AND tag="'.mysql_real_escape_string($q_tag).'";'));
    $max_p = ceil($nst["xt"] / 5);
    $page = min($page,$max_p);
    $start = ($page - 1) * 10;
    $ssnt = mysql_query('SELECT * FROM status_tag WHERE tag="'.mysql_real_escape_string($q_tag).'" AND member_id="'.mysql_real_escape_string($q_id).'" ORDER BY status_id DESC LIMIT '.$start.',10;');
    $ssss = mysql_fetch_assoc(mysql_query('SELECT * FROM member_info WHERE id="'.mysql_real_escape_string($q_id).'";'));
    $yyyy = mysql_fetch_assoc(mysql_query('SELECT timestamp FROM status_tag WHERE member_id="'.mysql_real_escape_string($q_id).'" AND tag="'.mysql_real_escape_string($q_tag).'" ORDER BY timestamp DESC LIMIT 0,1;'));
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
                    location.href = "s_search.php?id=<?php print(htmlspecialchars($_GET['id'])); ?>&w="+e;
                };
            </script>
            </div>
            </div>
        </div>
        <div id="content">
                <p class="blank"></p>
                    <div style="float:right;">
                    <span style="color:#615555;font-size:1.2em;">情報</span>
                     　  <p style="width:230px;opacity:0.7;height:2px;margin-bottom:0;background-color:#c6c6c6;margin-top:0;"></p>
                        <p style="margin-left:10px;font-size:0.8em;">
                            <div id="titlen" style="margin-left:10px;width:200px;padding-left:10px;">
                            <?php
                                $img = mysql_fetch_assoc(mysql_query('SELECT profile_image_url FROM profile_image WHERE id="'.mysql_real_escape_string($q_id).'";'));
                            ?>
                            <img src="<?php print(htmlspecialchars($img['profile_image_url'])); ?>" id="n" class="imgleft" width="48" height="48">
                            <span id="titlenn" style="font-size:0.8em;">作成者:
                            <p style="margin:0;margin-top:3px;margin-left:61px;width:140px;height:1px;background-color:#c6c6c6;"></p> 
                            @<strong><a  style="text-decoration:none;text-align:left;" href="user.php?id=<?php print(htmlspecialchars($q_id)); ?>"><?php print(htmlspecialchars($ssss["screen_name"])); ?></a></strong>
                            <br>
                            最終追加:
                            <p style="margin:0;margin-top:3px;margin-left:61px;width:140px;height:1px;background-color:#c6c6c6;"></p>
                            <strong><?php print(htmlspecialchars($yyyy["timestamp"])); ?></strong></span>
                            </div>
                        </p>
                        <span style="color:#615555;font-size:1.2em;">メニュー</span>
                     　  <p style="width:230px;opacity:0.7;height:2px;margin-bottom:0;background-color:#c6c6c6;margin-top:0;"></p>
                     　  <p style="margin-top:0px;margin-bottom:0px;padding:0;margin-left:10px;">
                        <button class="btn primary" style="width:210px;margin-top:5px;" onClick="location.href='tag_vv.php?id=<?php print(htmlspecialchars($q_id)) ?>&tag=<?php print(htmlspecialchars($q_tag)); ?>';">時系列順に表示</button><br><button class="btn" style="width:210px;">このまとめ内で検索</button><br><button class="btn" style="width:210px;">Twitterに投稿</button><br><button class="btn" style="width:210px;">おすすめに追加</button><br>
                        </p>
                     　 <br>
                    <span style="color:#615555;font-size:1.2em;">広告</span>
                    <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                    </div>
                    <?php
                        $output = '';
                        $output .= '<div style="width:650px;">';
                        $output .= '<span style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">'.htmlspecialchars($q_tag).' ('.htmlspecialchars($nst["xt"]).')</span>';
                        $output .= '<p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>';
                        $output .= '<div style="width:650px;">';
                        $output .= '<br>';    
                        while($data = mysql_fetch_assoc($ssnt)) {
                            $nn2 = mysql_fetch_assoc(mysql_query('SELECT * FROM site_directory WHERE site_url="'.mysql_real_escape_string($data["site_url"]).'";'));
                            $nn3 = mysql_fetch_assoc(mysql_query('SELECT * FROM member_status WHERE site_url="'.mysql_real_escape_string($data["site_url"]).'" AND member_id="'.mysql_real_escape_string($q_id).'";'));
                            $parsed = parse_url($nn2["site_url"]);
                            $output .= '<img src="http://www.google.com/s2/favicons?domain='.$parsed["host"].'">';
                            $output .= ' <a style="color:#615555;" href="site.php?id='.urlencode(htmlspecialchars(getSiteId($nn2["site_url"]))).'">'.mb_strimwidth(htmlspecialchars($nn2["title"]),0,80,"...",utf8).'</a>';
                            $output .= '<p style="margin-top:0px;font-size:0.7em;margin-left:0px;"><span style="color:#009933;">'.mb_strimwidth(htmlspecialchars($data["site_url"]),0,140,"...",utf8).'</span></p>';
                            $output .= '<p style="padding-left:10px;padding-right:10px;margin:0;font-size:0.8em;background-color:#e4e4e4;border-radius:3px;border:#a5999a 1px solid;">';
                            $comment = $nn3["comment"];
                            if($nn3["comment"] == "") {
                                $comment = "コメントなし";
                            }

                            $output .= '<strong>'.htmlspecialchars($nn3["comment"]).'</strong><br>投稿日:'.htmlspecialchars($nn3["timestamp"]).'';
                            if($nn2["type"] == 2) {
                            $output .= ' / <a href="edit_v.php?id='.htmlspecialchars($nn3["status_id"]).'">編集</a>';
                            }
                            else if($nn2["type"] == 0) {
                                $output .= ' / <a href="edit.php?id='.htmlspecialchars($nn3["status_id"]).'">編集</a>';
                            }
                            
                            $output .= '</p>';
                            $output .= '<br>';
                        }
                        $output .= '</div>';
                        
                            
                            print($output);
                        
                        if($q_status = "o") {
                            $n10 = mysql_fetch_assoc(mysql_query('SELECT * FROM status_tag WHERE member_id="'.mysql_real_escape_string($q_id).'" AND tag="'.mysql_real_escape_string($q_tag).'" ORDER BY status_id DESC;'));
                        }
                    ?>
                </p>
                 <div id="paging">
                            <?php if($page > 1) { ?>
                                <p style="margin:0;float:left;">
                                    <a href="tag_v.php?id=<?php print(htmlspecialchars($_GET['id'])) ?>&tag=<?php print(htmlspecialchars($_GET["tag"])); ?>&page=<?php print($page-1); ?>">前のページへ</a>
                                </p>
                            <?php } else { ?>
                                <p style="margin:0;float:left;">
                                    前のページへ
                                </p>
                            <?php } ?>
                            <?php if($page < $max_p) { ?>
                                 <p style="margin:0;float:right;">
                                    <a href="tag_v.php?id=<?php print(htmlspecialchars($_GET['id'])) ?>&tag=<?php print(htmlspecialchars($_GET["tag"])); ?>&page=<?php print($page+1); ?>">次のページへ</a>
                                </p>
                            <?php } else { ?>
                                 <p style="margin:0;float:left;">
                                    次のページ
                                </p>
                            <?php } ?>
                        </div>  
            <br>
           </div>
           <p class="blank"></p>
        </div>
        <div id="footer">
        </div>
    </body>
</html>
