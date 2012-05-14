<?php
    session_start();
    require("database_connect.php");
    $query  = htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
    function convert($scr) {
        $s2 = mysql_fetch_assoc(mysql_query('SELECT id FROM member_info WHERE screen_name="'.mysql_real_escape_string($scr).'";'));
        return $s2["id"];
    }
    function c2($id) {
        $s2 = mysql_fetch_assoc(mysql_query('SELECT screen_name FROM member_info WHERE id="'.mysql_real_escape_string($id).'";'));
        return $s2["screen_name"];
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
                     　  <button class="btn" style="width:190px;">すべての閲覧履歴</button><br>
                     　  <button class="btn" style="width:190px;">タグ済み</button><br>
                     　  <button class="btn" style="width:190px;">動画サイト</button><br>
                     　  <button class="btn" style="width:190px;">画像</button><br>
                     　 <br>
                    <span style="color:#615555;font-size:1.2em;">広告</span>
                    <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                    </div>
                    <div style="width:650px;">
                    <a href="" style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">まとめ一覧</a>
                    <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>
                    <br>
                    <ul class="tabs">
  <li class="active"><a href="#">登録数順にソート表示</a></li>
  <li><a href="#">時系列順に表示</a></li>
</ul>
<br>
<br>
                    <?php
                        $output = '';
                        $converted = $query;
                        $stn = mysql_query('SELECT DISTINCT status_tag.tag,COUNT(status_tag.site_url) AS xt FROM status_tag WHERE member_id="'.mysql_real_escape_string($converted).'" GROUP BY status_tag.tag ORDER BY xt DESC;');
                        $output .= '';
                        while($data = mysql_fetch_assoc($stn)) {
                            $stn4 = mysql_fetch_assoc(mysql_query('SELECT * FROM status_tag WHERE member_id="'.mysql_real_escape_string($query).'" AND tag="'.mysql_real_escape_string($data["tag"]).'";'));
                            $stn5 = mysql_fetch_assoc(mysql_query('SELECT COUNT(tag) AS xt FROM status_tag WHERE member_id="'.mysql_real_escape_string($stn4["member_id"]).'" AND tag="'.mysql_real_escape_string($stn4["tag"]).'";'));
                            
                            $output .= '<div class="bbtn_n"><img src="images/icon.png"> <a class="bbtn_table_a" href="tag_v.php?tag='.urlencode(htmlspecialchars($stn4["tag"])).'&id='.htmlspecialchars($stn4["member_id"]).'">'.htmlspecialchars($data["tag"]).'</a><span style="color:#000;font-size:0.9em;"> ('.$stn5["xt"].')</span><span style="float:right;margin-right:10px;"><span class="spp"><a style="text-decoration:none;" href="edit_t.php?tag='.htmlspecialchars(urlencode($stn4["tag"])).'&id='.htmlspecialchars($stn4["member_id"]).'"><span style="font-size:0.9em;color:#ffffff;text-decoration:none;">編集</span></a></span> <span class="spp3"><a href="all_tag.php?tag='.htmlspecialchars($data["tag"]).'" style="text-decoration:none;color:#ffffff;font-size:0.9em;">全域まとめタグ検索</a></span></span></div>';
                        }
                        
                        print($output);
                    ?>
                    <p class="blank"></p>
                    <br>
                </p>
            <br>
           </div>
           <p class="blank"></p>
        </div>
        <div id="footer">
        </div>
    </body>
</html>
