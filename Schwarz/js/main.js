var Schwarz = function(){};

var C = function(e,d) {
    var m = document.createElement(e);
    if(d && d instanceof Object) {
        for(var k in d) {
            e[k] = d[k];
        }
    }
    return e;
};
var $ = function(t) {
    return document.getElementById(t);
};
Schwarz.prototype.doLike = function() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST","like.php",true);
    xhr.send("id="+$("id")+"&k="+$("key"));
    xhr.setRequestHeader("Content-Type","application/urlform-encoded");
    
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 &&& xhr.status == 200) {
            var r = xhr.responseText;
            $("result").innerHTML = r;
        }
    }     
};
Schwarz.prototype.getTwitterProfile = function() {
    var id = $("userid").value;
    document.body.appendChild(
        C("script",{
            "type":"text/javascript",
            "src":"http://api.twitter.com/1/users/show/"+id+".json?suppress_response_codes&true&callback=callback",
            "charset":"utf-8",
        });
    );
    var callback = function() {
    };
};
var schwarz = new Schwarz();
$("like").onclick = function() {
    Schwarz.doLike();
};