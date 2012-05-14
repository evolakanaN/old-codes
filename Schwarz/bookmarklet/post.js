/*document.onkeydown = function(e) {
    code = e.which;
    chr = String.fromCharCode(code).toUpperCase();
    var t = e.srcElement || e.target;
    if(t.name != "comment") {
        switch(chr) {
            case "1":$("n1").checked = true;
                break;
            case "2":$("n2").checked = true;
                break;
            case "3":$("n3").checked = true;
                break;
            case "4":$("n4").checked = true;
                break;
            case "5":$("n5").checked = true;
                break;
            default:
        }
        if(code == "9") {
            $("c").focus();
        }
    }
    if(code == "13") {
        document.n.submit();
    }
}
*/
window.onload = function() {
    document.getElementById("c").focus();
}
document.onkeydown = function(e) {
    var code = e.which;
    if(code == 13) {
        send();
    }
};
document.getElementById("btn_k").onClick = send;
function send() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST","sys.php",true);
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xhr.send("uid="+document.getElementById("uid").value+"&title="+encodeURIComponent(document.getElementById("title").value)+"&comment="+encodeURIComponent(document.getElementById("c").value)+"&url="+encodeURIComponent(document.getElementById("url").value));
    document.getElementById("resp").innerHTML = "<p style='margin-left:20px;'>投稿中です...</p><br><br><div id='padding-top:90px;'></div>";
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            window.close();
        }
    };
}
