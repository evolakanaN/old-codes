<?php
    class ux_nu
    {   
        private $url = "http://ux.nu/api/short?url=";
        public function shorten($arg)
        {
            $req = file_get_contents($this->url."".urlencode($arg));
            $res = json_decode($req);
            return $res->data->url;
        }
    }