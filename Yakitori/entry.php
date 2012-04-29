<?php
    session_start();
    require("database_connect.php");
    
    $p = htmlspecialchars($_GET["no"],ENT_QUOTES,"UTF-8");
    $sql = mysql_query('SELECT * FROM entry WHERE entry_id="'.mysql_real_escape_string($p).'";');
    $data = mysql_fetch_assoc($sql);

?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Engineer's blog</title>
        <script type="text/javascript" src="main.js"></script>
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="scripts/shCore.js"></script>
	    <script type="text/javascript" src="scripts/shBrushJScript.js"></script>
        <script type="text/javascript">SyntaxHighlighter.all();</script>
    </head>
    <body>
        <center>
        <div id="bodyborder"></div>
        </center>
        
        <div id="container">
            <div id="hcont">
                <a href="http://verbindung.me/b/" class="c">Engineer's Blog</a>
                <div id="out">Verbindung+開発者のアップデート状況やお知らせを告知するブログです</div>
            </div>
            <div id="contents">
                <div class="link">
                    <ul>
                        <?php

                                $output = '';
                                $output .= '<li>';
                                $output .= '    <a href="http://verbindung.me/b/entry/php?no='.$data["entry_id"].'" style="font-size:1.5em;">'.$data["title"].'</a><br>';
                                $output .= '    <p class="line">Published at: '.$data["posted_at"].' | Author:'.$data["author"].' | No.'.$data["entry_id"].'</p>';
                                $output .= '</li><p style="color:gray;">'.$data["body"].'</p>';
                                print($output);
                        ?>
                        <br>
                        <br>
                        <p style="width:800px;height:1px;background-color:#c6c6c6;"></p>
                        <span style="color:gray">
                            Copyright(c) <a href="http://verbindung.me/id/sn0wnight/" class="gn">Sn0w Software</a> All Rights Reserved.<br>
                            Yakitori Blog Engine - developed by Sn0wNight.
                        </span>
                        <br>
                        <br>
                    </ul>
                </div>
            </div>
        </div>
        <br>
        <br>
    </body>
</html>