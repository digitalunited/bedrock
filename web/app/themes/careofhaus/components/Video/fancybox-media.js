$(document).ready(function () {
    function labnolIframe() {
        var iframe = document.createElement("iframe");
        iframe.setAttribute("src", "//www.youtube.com/embed/" + this.parentNode.dataset.id + "?autoplay=1&autohide=2&border=0&wmode=opaque&enablejsapi=1&showinfo=0");
        iframe.setAttribute("frameborder", "0");
        iframe.setAttribute("id", "youtube-iframe");
        this.parentNode.replaceChild(iframe, this);
    }

    (function () {
        var v = document.getElementsByClassName("youtube-player");
        for (var n = 0; n < v.length; n++) {
            var p = document.createElement("div");
            p.onclick = labnolIframe;
            v[n].appendChild(p);
        }
    })();
});
