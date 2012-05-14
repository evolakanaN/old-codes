window.onload = function() {
    var id = document.getElementById("user_id").value;
    alert(id);
    var scr = document.createElement("script");
    scr.type = "text/javascript";
    scr.src = "http://api.twitter.com/1/users/show"+id+".json?suppress_response_codes=true&callback=callback";
    scr.charset = "utf-8";
    
    document.body.appendChild(scr);
};
function callback(r) {
    document.getElementById("twitter_id").innerHTML = "<a href='http://twitter.com/"+r.screen_name+"' style='text-decoration:none;'>"+r.screen_name+"</a>";
    //document.getElementById("twitter_profile_url").innerHTML = "<img src='"+r.profile_image_url+"' class='imgleft' width='128' height='128'>";
    document.getElementById("twitter_bio").innerHTML = "";
    document.getElementById("twitter_profile_url").innerHTML = r.profile_image_url;
    alert(1);
}