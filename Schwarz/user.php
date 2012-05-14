<?php
    session_start();
    require("database_connect.php");
    require("twitteroauth/twitteroauth.php");
    require("lib/ux_nu.php");
    
    $query = htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
    $s1 = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS xt FROM member_info WHERE id="'.mysql_real_escape_string($query).'";'));
    
    if($s1["xt"] == 0){
        header("Location: http://schwarz.verbindung.me/error.php");
        exit;
    }
    $s2 = mysql_fetch_assoc(mysql_query('SELECT id FROM member_info WHERE id="'.mysql_real_escape_string($query).'";'));
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
                     　  <button class="btn primary" style="width:190px;margin-top:5px;">フォローする</button><br>
                     　  <button class="btn" style="width:190px;" onClick="location.href='<?php print(htmlspecialchars('page.php?id='.$query)) ?>';">すべての閲覧履歴</button><br>
                     　  <button class="btn" style="width:190px;" onClick="location.href='<?php print(htmlspecialchars('tag.php?id='.$query)); ?>';">まとめタグ</button><br>
                     　  <button class="btn" style="width:190px;" onClick="location.href='<?php print(htmlspecialchars('video.php?id='.$query)); ?>';">動画サイト</button><br>
                     　  <button class="btn" style="width:190px;" onClick="location.href='<?php print(htmlspecialchars('image.php?id='.$query)); ?>';">画像</button><br>
                     　 <br>
                    <span style="color:#615555;font-size:1.2em;">広告</span>
                    <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                    </div>
                    <div style="width:650px;">
                    <input type="hidden" value="<?php print(htmlspecialchars($query)); ?>" id="userid">
                    <script type="text/javascript">
                        function $(s) {
                            return document.getElementById(s);
                        }
                        
                            var id = $("userid").value;
                            var elem = document.createElement("script");
                            elem.type = "text/javascript";
                            elem.src = "http://api.twitter.com/1/users/show/"+id+".json?suppress_response_codes=true&callback=callback";
                            elem.charset = "utf-8";
                            document.body.appendChild(elem);
                        
                        function callback(r) {
                            $("twitter_id").innerHTML = "<a href='http://twitter.com/"+r.screen_name+"' style='text-decoration:none;'>@"+r.screen_name+"</a>";
                            $("twitter_bio").innerHTML = r.description;
                            $("twitter_location").innerHTML = r.location;
                            var replaced_profile = r.profile_image_url.replace("_normal","");
                            $("twitter_profile_url").innerHTML = "<img src='"+replaced_profile+"' id='n' class='imgleft' width='128' height='128'>";
                        }
                    </script>
                    <a href="" style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">ユーザープロフィール</a>
                    <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>
                    <br>
                        <span id="twitter_profile_url"></span>
                        <span style="font-size:2em;color:#615555;" id="twitter_id"></span>
                        <br>
                        <span style="font-size:1.1em;color:#b0aaaa" id="twitter_location"></span>
                        <br>
                        <span style="font-size:0.9em;color:#b0aaaa" id="twitter_bio"></span>
                        <br><br>
                        <br>
                        <br>
                        <br>
                     <span style="color:#615555;font-size:1.2em;">最近の閲覧履歴</span>
                     　<p style="opacity:0.7;height:2px;background-color:#c6c6c6;margin:0;"></p>
                        <br>
                     <div id="titlen" style="border:0;width:640px;padding:5px;">
                        <?php
                            $ss6 = mysql_query('SELECT title,site_url FROM member_status WHERE member_id="'.mysql_real_escape_string($s2["id"]).'" ORDER BY timestamp DESC LIMIT 0,10;');
                            while($data = mysql_fetch_assoc($ss6))
                            {
                                $ssn88 = mysql_fetch_assoc(mysql_query('SELECT site_id FROM site_directory WHERE site_url="'.mysql_real_escape_string($data["site_url"]).'";'));
                                $output = '';
                                $output .= '<li style="margin-left:10px;"><span style="font-size:0.8em;" class="t"><a href="site.php?id='.htmlspecialchars($ssn88["site_id"]).'" style="color:#;text-decoration:none;color:#615555;">'.htmlspecialchars(mb_strimwidth($data["title"],0,90,"...",utf8),ENT_QUOTES,"UTF-8").'</a></span></li>';
                                print($output);
                            }
                        ?>
                        
                    </div>
                    <br>
                    <span style="color:#615555;font-size:1.2em;">最新の画像</span>
                    <p style="opacity:0.7;height:2px;background-color:#c6c6c6;margin:0;"></p>
                    <div style="width:640px;padding:5px;">
                    <?php
                        $s3 = mysql_query('SELECT * FROM member_status,site_directory WHERE member_status.member_id="'.mysql_real_escape_string($query).'" AND member_status.site_url=site_directory.site_url AND site_directory.type=3 ORDER BY member_status.status_id DESC LIMIT 0,12;');
                        $pppn = "";
                        while($data = mysql_fetch_assoc($s3)) {
                            $parsedp = parse_url($data["site_url"]);
                            $mnnns = mysql_fetch_assoc(mysql_query('SELECT status_id FROM member_status WHERE site_url="'.mysql_real_escape_string($data["site_url"]).'";'));
                            $img_url = $data["site_url"];
                            if(preg_match("/http:\/\/twitpic\.com\/\w+/",$data["site_url"])) {
                                        $rep = explode("/",$parsedp["path"]);
                                        $id = $rep[1];
                                        $img_url = "http://twitpic.com/show/thumb/".$id;
                                    }
                                    else if(preg_match("/http:\/\/yfrog\.com\/\w+/",$data["site_url"])) {
                                        $rep = explode("/",$parsedp["path"]);
                                        $id = $rep[1];
                                        $img_url = "http://yfrog.com/".$id.":small";
                                    }
                                    else if(preg_match("/http:\/\/lockerz\.com\/s\/\w+/",$data["site_url"])) {
                                        $rep = explode("/",$parsedp["path"]);
                                        $id = $rep[2];
                                        $img_url = "http://api.plixi.com/api/tpapi.svc/imagefromurl?url=http://lockerz.com/s/".$id."&size=small";
                                    }
                                    else if(preg_match("/http:\/\/p\.twipple\.jp\/\w+/",$data["site_url"])) {
                                        $rep = explode("/",$parsedp["path"]);
                                        $id = join("/",str_split($rep[1]));
                                        $img_url = "http://p.twipple.jp/data/".$id.".jpg";
                                    }
                                    else if(preg_match("/http:\/\/pckles\.com\/[\w-_@]+\/\w+/",$data["site_url"])) {
                                        $rep = explode("/",$parsedp["path"]);
                                        $id = $rep[2];
                                        $user = $rep[1];
                                        $img_url = "http://pckles.com/".$user."/".$id.".resize.jpg";
                                        $thumb = "images/pckles.png";
                                    }
                                    else if(preg_match("/http:\/\/instagr\.am\/p\/\w+\//",$data["site_url"])) {
                                        $rep = explode("/",$parsedp["path"]);
                                        $id = $rep[2];
                                        $img_url = "http://instagr.am/p/".$id."/media/?size=t";
                                    }
                                    else if(preg_match("/http:\/\/photozou\.jp\/photo\/show\/\d+\/\d+/",$data["site_url"])) {
                                $rep = explode("/",$parsedp["path"]);
                                $id = $rep[4];
                                $img_url = "http://photozou.jp/p/img/".$id;
                            }
                            $pppn .= '<a style="border:0;" href="site.php?id='.htmlspecialchars($data["site_id"]).'"><img src="'.htmlspecialchars($img_url).'" height="90" width="90" style="border:#ffffff 4px solid;padding:3px;border-radius:3px;"></a>';
                        }
                        print($pppn);
                    ?>
                    </div>
                </p>
                <br>
                <br>
           </div>
        </div>
        <div id="footer">
        </div>
    </body>
</html>
