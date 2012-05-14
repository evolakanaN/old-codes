var $ = function(tag) {
    return document.getElementById(tag);
}
var change = function() {
    var radio = document.getElementsByName("share_k");
    if(radio[0].checked) {
        $("all").style.display = "";
        $("id_u").style.display = "none";
        $("only").style.display = "none";
    }
    if(radio[1].checked) {
        $("all").style.display = "none";
        $("id_u").style.display = "";
        $("only").style.display = "none";
    }
    if(radio[2].checked) {
        $("all").style.display = "none";
        $("id_u").style.display = "none";
        $("only").style.display = "";
    }
}
window.onload = change;
