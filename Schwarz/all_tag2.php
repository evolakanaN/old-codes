<?php
    require("database_connect.php");
    $q_tag = htmlspecialchars($_POST["tag"],ENT_QUOTES,"UTF-8");
    
    $s1 = mysql_query('SELECT DISTINCT status_tag.tag,status_tag.member_id,COUNT(status_tag.site_url) AS xt FROM status_tag WHERE status_tag.tag LIKE "%'.mysql_real_escape_string($q_tag).'%" GROUP BY status_tag.member_id ORDER BY xt DESC;');
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
            </div>
        </div>
        <div id="content">
                <p class="blank"></p>
                    <div style="float:right;">
                        <form action="all_tag2.php" method="POST" style="margin:0;padding:0;">
                        <span style="color:#615555;font-size:1.2em;">メニュー</span>
                        　  <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                        　 
                            <input type="text" name="tag" style="padding-top:3px;font-size:1.1em;width:135px;height:30px;border-radius:3px;border:#c6c6c6 1px solid;border-top-right-radius:0;border-bottom-right-radius:0;font-size:1em;" placeholder="検索クエリ...">
                            <input type="submit" id="spp3" class="spp3" style="border-top-left-radius:0;border-bottom-left-radius:0;margin-right:50px;margin-left:0;height:35px;margin-right:0px;margin-top:5px;" value="検索">
                            </form>            
                            <br>
                        　  <button class="btn info" style="width:190px;">Like数の多い順表示</button><br>
                        　  <button class="btn info" style="width:190px;">新着順表示</button><br>
                            <br>
                        　 <button class="btn" style="width:190px;margin-top:5px;">ユーザーページへ</button><br>
                     　  <button class="btn" style="width:190px;">まとめタグ</button><br>
                     　  <button class="btn" style="width:190px;">閲覧した動画</button><br>
                     　  <button class="btn" style="width:190px;">閲覧した画像</button><br>
                     　 <br>
                    <span style="color:#615555;font-size:1.2em;">広告</span>
                    <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                    </div>
                    <span style="color:#615555;font-size:1.2em;font-weight:bold;">全域タグ検索</span>
                    <p style="width:650px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                    <?php
                        $output = '';
                        while($data = mysql_fetch_assoc($s1)) {
                            $sc = mysql_fetch_assoc(mysql_query('SELECT profile_image_url FROM profile_image WHERE id="'.mysql_real_escape_string($data["member_id"]).'";'));
                            $iid = mysql_fetch_assoc(mysql_query('SELECT screen_name FROM member_info WHERE id="'.mysql_real_escape_string($data["member_id"]).'";'));
                            
                            $output .= '<div id="titlen">';
                            $output .= '<img src="'.htmlspecialchars($sc["profile_image_url"]).'" class="imgleft" width="64" height="64">';
                            $output .= '';
                            $output .= '<span id="titlenn" style="font-size:1.1em;"><a href="user.php?id='.htmlspecialchars($data["member_id"]).'" style="border:0;color:#615555;text-decoration:none;">@'.htmlspecialchars($iid["screen_name"]).'</a> / <a href="tag_v.php?id='.htmlspecialchars($data["member_id"]).'&tag='.htmlspecialchars($data["tag"]).'" style="border:0;color:#615555;text-decoration:none;"><strong>'.htmlspecialchars($data["tag"]).'</strong></a></span>';
                            $output .= '<br>';
                            $output .= '<p style="margin:0;margin-top:3px;margin-left:80px;width:540px;height:1px;background-color:#c6c6c6;"></p>';
                            $output .= '<span style="font-size:0.8em;">
                        <span style="font-weight:bold;background-color:pink;color:#red;padding-left:5px;padding-right:5px;">52Users</span> <span style="font-weight:bold;background-color:#96e373;color:green;padding-left:5px;padding-right:5px;">234Likes</span> <span style="font-weight:bold;background-color:#91c5fd;color:blue;padding-left:5px;padding-right:5px;">'.htmlspecialchars($data["xt"]).'scraped</span>';
                        $output .= '<br>';
                        $output .= '<p style="margin:0;margin-top:5px;font-size:0.8em;">';
                        $output .= '<a href="">ブックマーク追加</a>';
                        $output .= '</p>';
                        $output .= '</div><br>';
                            
                        }
                        print($output);
                    ?>
                
                    
                </p>
           <p class="blank"></p>
        </div>
        <div id="footer">
        </div>
    </body>
</html>
