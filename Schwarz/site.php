<?php
    session_start();
    require("database_connect.php");
    require("lib/ux_nu.php");
    
    
    $api = new ux_nu();
    $query = htmlspecialchars($_GET["id"],ENT_QUOTES,"UTF-8");
    $page = htmlspecialchars($_GET["page"],ENT_QUOTES,"UTF-8");
    if($page == "") {
        $page = 1;
    }
    $s1 = mysql_fetch_assoc(mysql_query('SELECT * FROM site_directory WHERE site_id="'.mysql_real_escape_string($query).'";'));
    
    $count_t = mysql_fetch_assoc(mysql_query('SELECT COUNT(*) AS xtt FROM site_view WHERE site_id="'.mysql_real_escape_string($query).'";'));
    if($count_t["xtt"] == 0) {
        mysql_query('INSERT INTO site_view SET site_id="'.mysql_real_escape_string($s1["site_id"]).'",view=1');
    } else if($count_t["xtt"] > 0) {
        mysql_query('UPDATE site_view SET view=view+1 WHERE site_id="'.mysql_real_escape_string($s1["site_id"]).'";');
    }
    $nntt = mysql_fetch_assoc(mysql_query('SELECT view FROM site_view WHERE site_id="'.mysql_real_escape_string($s1["site_id"]).'";'));
    function cname($id){
        $s = mysql_fetch_assoc(mysql_query('SELECT screen_name FROM member_info WHERE id="'.mysql_real_escape_string($id).'";'));
        return $s["screen_name"];
    }
    $s199 = mysql_fetch_assoc(mysql_query('SELECT COUNT(DISTINCT member_id) AS tt FROM member_status WHERE site_url="'.mysql_real_escape_string($s1["site_url"]).'";'));
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>
            Schwarz - <?php print(htmlspecialchars(mb_strimwidth($s1["title"],0,50,"...",utf8))); ?>
        </title>
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="js/jquery.js"></script>
    </head>
    <body>
        <script type="text/javascript">
            window.onload = function() {
             var srv = document.createElement("script");
            srv.type = "text/javascript";
            srv.src = "http://search.twitter.com/search.json/callback=callback&q=<?php print(htmlspecialchars($s1['title'])); ?>";
            document.body.appendChild(srv);
            function callback(j){
                var display = $("#twitter");
                $(j.results).each(function(i,v) {
                    display.append("<p class=\"blank\"></p><img src=\""+v.profile_image_url+"\" width=\"48\" hright=\"48\" class=\"imgleft\"><strong><a href=\"http://twitter.com/"+v.from_user+"\">@"+v.from_user+"</a></strong><br>"+v.text+"<br><p id=\"bu\"></p>");
                });
            }
        }
        </script>
        <div id="line_a">
            <span style="float:right;color:#ffffff;margin-right:50px;font-size:0.8em;margin-top:8px;opacity:0.5;">
                <?php if(isset($_SESSION["screen_name"])): ?>
                    <a href="">トップ</a> | <a href="">新着エントリ</a> | <a href="">アカウント設定</a> | <a href="">分類タグ</a> | <strong><a href="logout.php">ログアウト</a></strong>
                <?php endif; ?>
                <?php if(!isset($_SESSION["screen_name"])): ?>
                    <a href="">トップ</a> | <a href="">新着エントリ</a> | <strong><a href="redirect.php">Sign in with twitter</a></strong>
                <?php endif; ?>
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
                    <div style="float:right;padding-left:10px;">
                        <span style="color:#615555;font-size:1.2em;">情報</span>
                     　  <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                        <div id="titlen" style="width:210px;height:95px;padding:0;margin:0;text-shadow: 0 1px 0 #ffffff;margin-left:5px;">
                            <p style="float:right;width:110px;margin:0;padding:0;">
                                <span style="float:left;margin-right:10px;font-weight:bold;font-size:2em;color:#615555;padding-top:10px;">45</span>
                                <br>
                                <span style="font-size:0.7em;margin-right:25px;margin-top:2.5px;float:left;">人がいいね!</span>
                            </p>
                            
                            <p style="width:150px;margin:0;padding:0;">
                                <p style="padding-top:10px;margin:0;"></p>
                                <span style="font-weight:bold;font-size:2em;margin-left:10px;color:#615555;"><?php print(htmlspecialchars($s199["tt"])); ?></span>
                                <br>
                                <span style="font-size:0.7em;margin-left:10px;padding:0;margin-top:0;">ブックマーク </span>
                                <p style="margin:0;margin-top:3px;margin-bottom:5px;width:210px;height:1px;background-color:#c6c6c6;">
                        
                             <p style="font-size:0.8em;margin:0;margin-top:2px;margin-left:10px;"><span style="color:#615555;"><img src="images/watch.png" width="16" height="11"> </span><span style="color:#615555;font-weight:bold;"><?php print(htmlspecialchars($nntt["view"])); ?></span><span style="color:#615555;">アクセス</span></p>
                         </p>
                         
                         </div>
                         <br>
                        <span style="color:#615555;font-size:1.2em;">メニュー</span>
                     　 <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p><button class="btn primary" style="width:210px;margin-top:5px;margin-left:10px;">ブックマークする</button><br><button class="btn info" style="width:210px;margin-left:10px;">Twitterに投稿</button><br><?php if(preg_match("/http:\/\/www\.youtube\.com\/watch/",$s1["site_url"])): ?><button class="btn" style="width:210px;margin-left:10px;">プレイリスト追加</button><br>
                     　  <?php endif; ?>
                     　 <br>
                    <span style="color:#615555;font-size:1.2em;">広告</span>
                    <p style="width:230px;opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>
                    <p style="margin-left:20px;"></p>
                    </div>
                    <div style="width:650px;">
                    <?php
                        $s2 = mysql_query('SELECT member_id,comment FROM member_status WHERE site_url="'.mysql_real_escape_string($s1["site_url"]).'" AND comment <> "";');
                        $output = "";
                        if($s1["type"] == 0) 
                        {
                            $output .= '<span style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">サイト情報</span>';
                            $output .= '<p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>';
                            $output .= '<br>';
                            
                            $output .= '<div id="titlen" style="width:610px;padding-right:20px;height:150px;">';
                            $output .= '<img src="http://capture.heartrails.com/150x150/border/round?'.htmlspecialchars($s1["site_url"]).'" class="imgleft" width="150" height="150">';
                            $output .= '<a style="text-decoration:none;text-shadow: 0 1px 0 #ffffff;color:#615555;font-weight:bold;" href="'.htmlspecialchars($s1["site_url"]).'">'.htmlspecialchars($s1["title"]).'</a>';
                            $output .= '<br>';
                            $output .= '<span style="text-shadow: 0 1px 0 #ffffff;font-size:0.8em;color:#009933;">'.htmlspecialchars(mb_strimwidth($s1["site_url"],0,140,"...",utf8)).'</span>';
                            $output .= '</div>';
                            $output .= '<br>';
                            /*$output .= '<div style="610px;height:150px;background-image:url("http://capture.heartrails.com/150x150/border/round?'.htmlspecialchars($s1["site_url"]).'");z-index:-1;" class="imgleft" width="150" height="150">';
                            $output .= '<div style="border-radius:5px;background-color:#000000;opacity:0.6;width:610px;height:150px;z-index:1;"></div>';
                            $output .= '<a style="text-decoration:none;text-shadow: 0 1px 0 #ffffff;color:#615555;font-weight:bold;" href="'.htmlspecialchars($s1["site_url"]).'">'.htmlspecialchars($s1["title"]).'</a>';
                            $output .= '<br>';
                            $output .= '<span style="text-shadow: 0 1px 0 #ffffff;font-size:0.8em;color:#009933;">'.htmlspecialchars(mb_strimwidth($s1["site_url"],0,140,"...",utf8)).'</span>';
                            $output .= '</div>';
                            */
                            $output .='<span style="color:#615555;font-size:1.2em;">Schwarzユーザーのコメント</span>';
                            $output .= '<p style="opacity:0.5;height:2px;background-color:#c6c6c6;margin-top:0;"></p>';
                            $output .= '<div class="comment" style="background-color:#e3e3e3;width:640px;padding:5px;font-size:0.8em;">';
                            while($dat = mysql_fetch_assoc($s2)) {
                                $snn = mysql_fetch_assoc(mysql_query('SELECT profile_image_url FROM profile_image WHERE id="'.mysql_real_escape_string($dat["member_id"]).'";'));
                                $output .= '<img src="'.htmlspecialchars($snn["profile_image_url"]).'" width="16" height="16" style="border-radius:3px;margin-left:5px;"> @<a href="user.php?id='.htmlspecialchars($dat["member_id"]).'" style="color:#615555;">'.htmlspecialchars(cname($dat["member_id"])).'</a> : '.htmlspecialchars($dat["comment"]).'<br>';
                                /*$output .= htmlspecialchars($dat["comment"]).'<br><img src="'.htmlspecialchars($snn["profile_image_url"]).'" width="16" height="16" style="border-radius:3px;">@<a href="user.php?id='.htmlspecialchars($dat["member_id"]).'" style="color:#615555;">'.htmlspecialchars(cname($dat["member_id"])).'</a><br>';*/
                            }
                            $output .= '</div>';
                            $output .= '</p>';
                            
                            $output .= '<span style="color:#615555;font-size:1.2em;">Twitterでの反応</span>';
                            $output .= '<p style="opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>';
                            $output .= '<div style="padding:10px;width:630px;background-color:#c6c6c6;font-weight:bold;width:630px;border-radius:3px;margin:0;">';
                            //ここに類似度の実装を後からやる
                            $output .= '<div id="twitter"></div>';
                            $output .= '</div>';
                            $output .= '<br><p class="blank"></p>';
                        }
                        if($s1["type"] == 2)
                        {
                            $parsed = parse_url($s1["site_url"]);
                           if(preg_match("/www\.youtube\.com\/watch/",$parsed["host"].$parsed["path"])){
                                $flag = "youtube";
                                parse_str($parsed["query"],$q);
                                $embed = '<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.htmlspecialchars($q["v"]).'?autoplay=1&amp;rel=0&amp;enablejsapi=1&amp;playerapiid=ytplayer&amp;hl=ja&amp;version=3" id="schwarz_player" width="630" height="315"><param name="allowScriptAccess" value="always"></param></object>';
                                $download = '';
                            }
                            else if(preg_match("/www\.dailymotion\.com\/video/",$s1["site_url"])) {
                                $flag = "dailymotion";
                                $exped = explode("/",$parsed["path"]);
                                $parsed_exp = explode("_",$exped[2]); //ID = $parsed_exp[0]
                                
                                $embed = '<iframe frameborder="0" width="630" height="315" src="http://www.dailymotion.com/embed/video/'.htmlspecialchars($parsed_exp[0]).'"></iframe>';
                            }
                            else if(preg_match("/vimeo\.com\//",$s1["site_url"])) {
                                $flag = "vimeo";
                                $embed = '<iframe src="http://player.vimeo.com/video'.$parsed["path"].'?title=0&amp;byline=0&amp;portrait=0" width="630" height="315" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';   
                            }
                            else if(preg_match("/www\.nicovideo\.jp\/watch/",$parsed["host"].$parsed["path"])) {
                                $flag = "nicovideo";
                                if(strstr($parsed["query"],"?") == false) {
                                    $nico_v = explode("/",$parsed["path"]);
                                    $q = $nico_v[2];
                                    $embed = '<script type="text/javascript" src="http://ext.nicovideo.jp/thumb_watch/'.$q.'?w=630&h=315"></script>';
                                    $download = "";
                                }
                                else{
                                    $nico_v = explode("/",$parsed["path"]);
                                    $q = "sm".$nico_v[2];
                                    $embed = '<script type="text/javascript" src="http://ext.nicovideo.jp/thumb_watch/'.$q.'?w=630&h=315"></script>';
                                    $download = "";
                                }
                            }
                            else if(preg_match("/http:\/\/www\.veoh\.com\/watch\/\w+/",$s1["site_url"])) {
                                $flag = "veoh";
                                $rep = explode("/",$parsed["path"]);
                                $id = $rep[2];
                                $embed = '<embed src="http://www.veoh.com/swf/webplayer/WebPlayer.swf?version=AFrontend.5.7.0.1281&permalinkId='.$id.'&player=videodetailsembedded&videoAutoPlay=0&id=anonymous" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="630" height="315" id="veohFlashPlayerEmbed" name="veohFlashPlayerEmbed"></embed>';
                                $download = "";
                            }
                            else if(preg_match("/http:\/\/www\.ustream\.tv\/recorded\/\d+/",$s1["site_url"])) {
                                $flag = "ustream_recorded";
                                $rep = explode("/",$parsed["path"]);
                                $id = $rep[2];
                                $embed = '<iframe src="http://www.ustream.tv/embed/recorded/'.$id.'" width="630" height="315" scrolling="no" frameborder="0" style="border: 0px none transparent;"></iframe>';
                                $download = "";
                            }
                            else if(preg_match("/http:\/\/www\.im\.tv\/vlog\/[pP]ersonal\/\d+\/\d+/",$s1["site_url"])) {
                                $flag = "vlog";
                                $rep = explode("/",$parsed["path"]);
                                $embed = "<embed src=http://myvlog.im.tv/?id=".$rep[4]."&mid=".$rep[3]."&MemberID=&inIMTV=Y&album=0&playnext=0' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' name='vlog".$rep[4]."' allowScriptAccess='always' allowFullScreen='true' type='application/x-shockwave-flash' width='630' height='315'></embed>";
                            }
                            $output .= '<a href="'.htmlspecialchars($s1["site_url"]).'" style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">'.mb_strimwidth(htmlspecialchars($s1["title"]),0,65,"...",utf8).'</a>
                    <p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p><br>';
                            $output .= '';
                            $output .= $embed.'<br>';
                            $output .= '<br>';
                            $output .= '<span style="color:#615555;font-size:1.2em;">Schwarzユーザーのコメント</span><p style="opacity:0.7;height:2px;background-color:#c6c6c6;margin:0;"></p><br><div class="comment" style="width:640px;padding:5px;font-size:0.8em;">';
                            while($data = mysql_fetch_assoc($s2))
                            {
                                /*$output .= '@<a href="user.php?id='.htmlspecialchars(cname($data["member_id"])).'" style="color:#615555;">'.htmlspecialchars(cname($data["member_id"])).'</a> : '.htmlspecialchars($data["comment"]).'<br>';*/
                                $snn = mysql_fetch_assoc(mysql_query('SELECT profile_image_url FROM profile_image WHERE id="'.mysql_real_escape_string($data["member_id"]).'";'));
                                $output .= '<img src="'.htmlspecialchars($snn["profile_image_url"]).'" width="16" height="16" style="border-radius:3px;margin-left:5px;"> @<a href="user.php?id='.htmlspecialchars($data["member_id"]).'" style="color:#615555;">'.htmlspecialchars(cname($data["member_id"])).'</a> : '.htmlspecialchars($data["comment"]).'<br>';
                            }
                            $output .= '</div>';
                            $output .= '</p>';
                            $output .= '<span style="color:#615555;font-size:1.2em;">類似度の高いサイト</span>';
                            $output .= '<p style="opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p><p class="blank"></p>';
                            //ここに類似度の実装を後からやる
                            $output .= '';
                            $output .= '<br>';   
                        }
                        if($s1["type"] == 3) {
                            $parsed = parse_url($s1["site_url"]);
                            $thumb = "http://www.google.com/s2/favicons?domain=".$parsed["host"];
                            if(preg_match("/http:\/\/twitpic\.com\/\w+/",$s1["site_url"])) {
                                $rep = explode("/",$parsed["path"]);
                                $id = $rep[1];
                                $img_url = "http://twitpic.com/show/large/".$id;
                            }
                            else if(preg_match("/http:\/\/yfrog\.com\/\w+/",$s1["site_url"])) {
                                $rep = explode("/",$parsed["path"]);
                                $id = $rep[1];
                                $img_url = "http://yfrog.com/".$id.":medium";
                            }
                            else if(preg_match("/http:\/\/lockerz\.com\/s\/\w+/",$s1["site_url"])) {
                                $rep = explode("/",$parsed["path"]);
                                $id = $rep[2];
                                $img_url = "http://api.plixi.com/api/tpapi.svc/imagefromurl?url=http://lockerz.com/s/".$id."&size=medium";
                            }
                            else if(preg_match("/http:\/\/p\.twipple\.jp\/\w+/",$s1["site_url"])) {
                                $rep = explode("/",$parsed["path"]);
                                $id = join("/",str_split($rep[1]));
                                $img_url = "http://p.twipple.jp/data/".$id.".jpg";
                            }
                            else if(preg_match("/http:\/\/www\.flickr\.com\/photos\/[\w-_@]+\/(\d+)/",$s1["site_url"])) {
                                $rep = explode("/",$parsed["path"]);
                                $id = $rep[3];
                                $res = file_get_contents("http://www.flickr.com/services/rest?method=flickr.photos.getInfo
&format=json&api_key=b1c0108b96613a249888d7004a46ed3d&photo_id=".$id."&jsoncallback=callback");
                                $json = json_encode($res);
                                $img_url = "http://farm".$json->photo->farm.".static.flickr.com/".$json->photo->server."/".$json->photo->id."_".$json->photo->secret."_s.jpg";
                            }
                            else if(preg_match("/http:\/\/pckles\.com\/[\w-_@]+\/\w+/",$s1["site_url"])) {
                                $rep = explode("/",$parsed["path"]);
                                $id = $rep[2];
                                $user = $rep[1];
                                $img_url = "http://pckles.com/".$user."/".$id.".resize.jpg";
                                $thumb = "images/pckles.png";
                            }
                            else if(preg_match("/http:\/\/[^\s]*?\.(jpg|png|jpeg|gif)/",$s1["site_url"])) {
                                $img_url = $s1["site_url"];
                            }
                            else if(preg_match("/http:\/\/instagr\.am\/p\/\w+\//",$s1["site_url"])) {
                                        $rep = explode("/",$parsed["path"]);
                                        $id = $rep[2];
                                        $img_url = "http://instagr.am/p/".$id."/media/?size=m";
                            }
                            else if(preg_match("/http:\/\/photozou\.jp\/photo\/show\/\d+\/\d+/",$s1["site_url"])) {
                                $rep = explode("/",$parsed["path"]);
                                $id = $rep[4];
                                $img_url = "http://photozou.jp/p/img/".$id;
                            }
                            
                            $output .= '<span style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">画像サムネイル</span>';
                            $output .= '<p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>';
                            $output .= '<br>';
                            $output .= '<center><img src="'.$img_url.'" style="border:#ffffff 10px solid;-webkit-box-shadow:0px 0px 10px gray;" height="250"></center>';
                            $output .= '<br>';
                            $output .= '<div id="titlen" style="width:610px;padding-right:20px;">
                            <img src="'.htmlspecialchars($thumb).'" class="imgleft" width="42" height="42">
                            <a style="text-decoration:none;text-shadow: 0 1px 0 #ffffff;color:#615555;font-weight:bold;" href="'.htmlspecialchars($s1["site_url"]).'">'.htmlspecialchars($s1["title"]).'</a>
                            <br>
                            <span style="text-shadow: 0 1px 0 #ffffff;font-size:0.8em;color:#009933;">'.htmlspecialchars($s1["site_url"]).'</span>
                            </div>';
                            $output .= '<br>';
                            $output .= '<span style="color:#615555;font-size:1.2em;">Schwarzユーザーのコメント</span><p style="opacity:0.7;height:2px;background-color:#c6c6c6;margin:0;"></p><br><div class="comment" style="width:640px;padding:5px;font-size:0.8em;">';
                            while($data = mysql_fetch_assoc($s2))
                            {
                                /*$output .= '@<a href="user.php?id='.htmlspecialchars(cname($data["member_id"])).'" style="color:#615555;">'.htmlspecialchars(cname($data["member_id"])).'</a> : '.htmlspecialchars($data["comment"]).'<br>';*/
                                $snn = mysql_fetch_assoc(mysql_query('SELECT profile_image_url FROM profile_image WHERE id="'.mysql_real_escape_string($data["member_id"]).'";'));
                                $output .= '<img src="'.htmlspecialchars($snn["profile_image_url"]).'" width="16" height="16" style="border-radius:3px;margin-left:5px;"> @<a href="user.php?id='.htmlspecialchars($data["member_id"]).'" style="color:#615555;">'.htmlspecialchars(cname($data["member_id"])).'</a> : '.htmlspecialchars($data["comment"]).'<br>';
                            }
                            $output .= '</div>';
                            $output .= '</p>';
                            $output .= '<span style="color:#615555;font-size:1.2em;">類似度の高いサイト</span>';
                            $output .= '<p style="opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p><p class="blank"></p>';
                            //ここに類似度の実装を後からやる
                            $output .= '';
                            $output .= '<br>';   
                        }
                        if($s1["type"] == 5) 
                        {
                            $parsed = parse_url($s1["site_url"]);
                            $exp = explode("/",$parsed["path"]);
                            $num = $exp[1];
                            $output .= '<span style="color:#615555;font-weight:bold;text-decoration:none;font-size:1.2em;">'.htmlspecialchars($s1["title"]).'</span>';
                            $output .= '<p style="opacity:0.7;height:2px;background-color:#c6c6c6;font-weight:bold;width:650px;margin:0;"></p>';
                            $output .= '<br>';
                            $output .= '<div style="font-size:0.8em;width:650px;">';
                            $output .= '<script src="https://gist.github.com/'.htmlspecialchars($num).'.js"></script>';
                            $output .= '</div>';
                            $output .= '<br>';
                            /*$output .= '<div style="610px;height:150px;background-image:url("http://capture.heartrails.com/150x150/border/round?'.htmlspecialchars($s1["site_url"]).'");z-index:-1;" class="imgleft" width="150" height="150">';
                            $output .= '<div style="border-radius:5px;background-color:#000000;opacity:0.6;width:610px;height:150px;z-index:1;"></div>';
                            $output .= '<a style="text-decoration:none;text-shadow: 0 1px 0 #ffffff;color:#615555;font-weight:bold;" href="'.htmlspecialchars($s1["site_url"]).'">'.htmlspecialchars($s1["title"]).'</a>';
                            $output .= '<br>';
                            $output .= '<span style="text-shadow: 0 1px 0 #ffffff;font-size:0.8em;color:#009933;">'.htmlspecialchars(mb_strimwidth($s1["site_url"],0,140,"...",utf8)).'</span>';
                            $output .= '</div>';
                            */
                            $output .='<span style="color:#615555;font-size:1.2em;">Schwarzユーザーのコメント</span>';
                            $output .= '<p style="opacity:0.5;height:2px;background-color:#c6c6c6;margin-top:0;"></p>';
                            $output .= '<div class="comment" style="background-color:#e3e3e3;width:640px;padding:5px;font-size:0.8em;">';
                            while($dat = mysql_fetch_assoc($s2)) {
                                $snn = mysql_fetch_assoc(mysql_query('SELECT profile_image_url FROM profile_image WHERE id="'.mysql_real_escape_string($dat["member_id"]).'";'));
                                $output .= '<img src="'.htmlspecialchars($snn["profile_image_url"]).'" width="16" height="16" style="border-radius:3px;margin-left:5px;"> @<a href="user.php?id='.htmlspecialchars($dat["member_id"]).'" style="color:#615555;">'.htmlspecialchars(cname($dat["member_id"])).'</a> : '.htmlspecialchars($dat["comment"]).'<br>';
                                /*$output .= htmlspecialchars($dat["comment"]).'<br><img src="'.htmlspecialchars($snn["profile_image_url"]).'" width="16" height="16" style="border-radius:3px;">@<a href="user.php?id='.htmlspecialchars($dat["member_id"]).'" style="color:#615555;">'.htmlspecialchars(cname($dat["member_id"])).'</a><br>';*/
                            }
                            $output .= '</div>';
                            $output .= '</p>';
                            
                            $output .= '<span style="color:#615555;font-size:1.2em;">Twitterでの反応</span>';
                            $output .= '<p style="opacity:0.7;height:2px;background-color:#c6c6c6;margin-top:0;"></p>';
                            $output .= '<div style="padding:10px;width:630px;background-color:#c6c6c6;font-weight:bold;width:630px;border-radius:3px;margin:0;">';
                            //ここに類似度の実装を後からやる
                            $output .= '<div id="twitter"></div>';
                            $output .= '</div>';
                            $output .= '<br><p class="blank"></p>';
                        }
                        print($output);
                    ?>
                </div>
            </div>
        <div id="footer">
        </div>
    </body>
</html>