/**
 * Created by user on 1/28/15.
 */
$(function(){
    if(checkCookie()){
        $('#tempFrame').hide();
    }
});
function SendMessage() {
    var win = document.getElementById("ifrmChild").contentWindow;
    if (win == null || !window['postMessage'])
        console.log("oh crap");
    else
        win.postMessage("hello", "*");
}
function ReceiveMessage(evt) {
    var message;
    if (false) {
        message = 'You ("' + evt.origin + '") are not worthy';
    }
    else {
        if (evt.origin.indexOf('haytuyet.com')) {
            if(evt.data == 'ok') {
                $('#tempFrame').hide();
                players['player1'].playVideo();
                setCookie('liked', true, 365);
            }
        }
    }
    if (message) {
        var ta = document.getElementById("taRecvMessage");
        if (ta == null)
            console.log(message);
        else
            document.getElementById("taRecvMessage").innerHTML = message;
    }
    //evt.source.postMessage("thanks, got it ;)", event.origin);
} // End Function ReceiveMessage

if (!window['postMessage'])
    console.log("oh crap");
else {
    if (window.addEventListener) {
        window.addEventListener("message", ReceiveMessage, false);
    }
    else {
        window.attachEvent("onmessage", ReceiveMessage);
    }
}
function checkCookie() {
    var liked=getCookie("liked");
    if (liked!='') return true;
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}