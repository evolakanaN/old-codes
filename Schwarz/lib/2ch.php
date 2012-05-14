<?php
    class nchd
    {
        private $_thread_k;
        private $_thread_n;
 
        public function getLogURL($req_url)
        {
            $parsed = parse_url($req_url);
            $exp = explode("/",$parsed["path"]);
 
            $this->_thread_k = $exp[4];
            $this->_thread_n = $exp[3];
            $url = "http://mimizun.com/log/2ch/".$this->_thread_n."/".$this->_thread_k;
            return $url;
        }
    }
    $ch = new nchd();
    print($ch->getLogURL("http://yuzuru.2ch.net/test/read.cgi/mmoqa/1315627458/"));

