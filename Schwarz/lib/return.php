<?php
function return_r($_cap){
    $_ts = "";
    $_exp = explode("]",$_cap);
    for($_i=0; $_i<count($_exp); $_i++){
        $_ts .= str_replace("[","",$_exp[$_i]).",";
    }
    $_ret = explode(",",$_ts);
    for($_j=0; $_j<count($_ret); $_j++) {
        if($_ret[$_j] == "" || $_ret[$_j] == NULL) {
            array_splice($_ret,$_j);
        }
    }
    return $_ret;
}
