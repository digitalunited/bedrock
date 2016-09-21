$(document).ready(function () {
    $('.alert__acceptbutton').on('click', function (e) {
        e.preventDefault();
        var d, daysBeforeExpire;
        daysBeforeExpire = 365;
        d = new Date();
        d.setTime(d.getTime() + (daysBeforeExpire * 24 * 60 * 60 * 1000));
        document.cookie = 'cookie-accepted=true;expires=' + d.toUTCString();
        $('.component-cookiealert').hide();
    });

    if (document.cookie.indexOf('cookie-accepted') < 0) {
        $('.component-cookiealert').show();
    }
});
