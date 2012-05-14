<?php
    session_start();
    require("database_connect.php");
    
    $query = htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
    $s1 = mysql_fetch_assoc(mysql_query('SELECT COUNT(id) AS x FROM member_info WHERE id="'.mysql_real_escape_string($query).'";'));
    
    function getSiteType($url){
        $sql = mysql_fetch_assoc(mysql_query('SELECT type FROM site__directory WHERE site_url="'.mysql_real_escape_string($url).'";'));
        return $sql["type"];
    }
    if($s1["x"] == 0){
        header("Location: error.php");
        exit;
    }
    $page = $_GET["page"];
    if($_GET["page"] == "") {
        $page = 1;
    }
    $page = max($page,1);
    $ss1 = mysql_fetch_assoc(mysql_query('SELECT id,screen_name FROM member_info WHERE id="'.mysql_real_escape_string($query).'";'));
    $sa7 = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS cnt FROM member_status WHERE member_id="'.mysql_real_escape_string($ss1["id"]).'";'));
    $max_p = ceil($sa7["cnt"]/5);
    $page = min($page,$max_p);
    $start = ($page - 1) * 10;
    $s2 = mysql_query('SELECT * FROM member_status,site_directory WHERE member_status.member_id="'.mysql_real_escape_string($ss1["id"]).'" AND member_status.site_url=site_directory.site_url AND site_directory.type=2 ORDER BY member_status.status_id DESC LIMIT '.$start.',10;');
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
                        <span style="color:#615555;font-size:1.2em;">メニュー</span>
                     　  <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                     　  <button class="btn primary" style="width:190px;margin-top:5px;">検索</button><br>
                     　  <button class="btn" style="width:190px;" onClick="location.href='user.php?id=<?php print(htmlspecialchars($_GET['id'])); ?>';">ユーザーページ</button><br>
                     　  <button class="btn" style="width:190px;" onClick="location.href='tag.php?id=<?php print(htmlspecialchars($_GET['id'])); ?>';">タグ済み</button><br>
                     　  <button class="btn" style="width:190px;" onClick="location.href='page.php?id=<?php print(htmlspecialchars($_GET['id'])); ?>';">閲覧した履歴</button><br>
                     　  <button class="btn" style="width:190px">画像</button>
                     　  <br>
                     　 <br>
                    <span style="color:#615555;font-size:1.2em;">広告</span>
                    <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                    <p style="margin-left:10px;">
                    </p>
                    </div>
                    <div style="width:650px;">
                    <a href="" style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">閲覧した動画サイト</a>
                    <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>
                    <br>
                    <?php
                        $output = '';
                        $ctt = mysql_fetch_assoc(mysql_query('SELECT COUNT(site_url) AS tn FROM member_status WHERE member_id="'.mysql_real_escape_string($ss1["id"]).'";'));
                        if($ctt["tn"] > 0){
                            while($data = mysql_fetch_assoc($s2)){
                                $parsed = parse_url($data["site_url"]);
                                $output .= '<img src="http://www.google.com/s2/favicons?domain='.$parsed["host"].'">';
                                $output .= ' <a href="site.php?id='.htmlspecialchars($data["site_id"]).'" style="color:#615555;">'.htmlspecialchars($data["title"]).'</a>';
                                $comment = $data["comment"];
                                if($data["comment"] == "") {
                                    $comment = "コメントなし";
                                }
                                $output .= '<p style="margin-top:0px;font-size:0.7em;margin-left:0px;"><span style="color:#009933;">'.htmlspecialchars(mb_strimwidth($data["site_url"],0,140,"...",utf8)).'</span><br><p style="padding-left:10px;padding-right:10px;margin:0;font-size:0.8em;background-color:#e4e4e4;border-radius:3px;border:#a5999a 1px solid;"><strong>'.htmlspecialchars($comment).'</strong><br>投稿日: '.htmlspecialchars($data["timestamp"]).'';
                                if(isset($_SESSION["user_id"]) && $query == $_SESSION["user_id"]) {
                                    $output .= ' / <a href="edit_v.php?id='.htmlspecialchars($data["status_id"]).'">編集</a>';
                                }
                                $output .= '</span></span></p>';
                                $output .= '<br>';
                            }
                        }
                        print($output);
                        ?>
                        <br>
                        <div id="paging">
                            <?php if($page > 1) { ?>
                                <p style="margin:0;float:left;">
                                    <a href="video.php?id=<?php print(htmlspecialchars($_GET['id'])) ?>&page=<?php print($page-1); ?>">前のページへ</a>
                                </p>
                            <?php } else { ?>
                                <p style="margin:0;float:left;">
                                    前のページへ
                                </p>
                            <?php } ?>
                            <?php if($page < $max_p) { ?>
                                 <p style="margin:0;float:right;">
                                    <a href="video.php?id=<?php print(htmlspecialchars($_GET['id'])) ?>&page=<?php print($page+1); ?>">次のページへ</a>
                                </p>
                            <?php } else { ?>
                                 <p style="margin:0;float:left;">
                                    次のページ
                                </p>
                            <?php } ?>
                        </div>            
                    <br>
                <br>
           </div>
           <p class="blank"></p>
        </div>
        <div id="footer">
        </div>
    </body>
</html>