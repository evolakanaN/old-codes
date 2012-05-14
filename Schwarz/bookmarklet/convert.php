<?php
  $query = htmlspecialchars($_GET["url"]);
  if(!empty($query)) {
    $pe = explode("/",parse_url($_GET["url"])["path"])[2];
    $fp = fsockopen("localhost",4567,$errno,$errstr,30);
    $http = "GET /req/".$pe." HTTP/1.1\r\n";
    $http .= "Host: localhost\r\n";
    $http .= "Connection: Close\r\n\r\n";
    fwrite($fp,$http);
    fclose($fp);
    print("finished");
  }