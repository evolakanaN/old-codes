function vote(r) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST","/vote.php",true);
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xhr.send("id="+document.getElementById("user_id").value+"&s="+r);   
    xhr.onreadystatechange = function(){
        if((xhr.readyState == 4) && (xhr.status == 200))
        {
            var res = xhr.responseText;
            document.getElementById("vote_r").value = "　"+res+" 人がこの人に対して拍手しています　";
            localStorage["v"+document.getElementById("user_id").value] = r;
        }
        else
        {
            return false;
        }
    }
}