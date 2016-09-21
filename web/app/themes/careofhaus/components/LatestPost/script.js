var getUnreadBlogPosts;

getUnreadBlogPosts = function () {
    var blogLink, blogUrl;
    blogLink = $('.navigation--tabbar .signal');
    blogLink.append('<span id="unread_blog" class="unreads" style="display:none;"><span></span></span>');
    if (localStorage.getItem('unreadBlogPosts')) {
        blogLink.find('#unread_blog').show();
        blogLink.find('#unread_blog>span').html(localStorage.getItem('unreadBlogPosts'));
    }
    blogUrl = '';
    return $.get(urls.ajaxurl, {
        action: 'latest_post',
        archive: $('body.blog').length
    }, function (res) {
        res = $.parseJSON(res);
        if (res.length > 0) {
            blogLink.find('#unread_blog').show();
            blogLink.find('#unread_blog>span').html(res.length);
            return localStorage.setItem('unreadBlogPosts', res.length);
        } else {
            localStorage.removeItem('unreadBlogPosts');
            return $('#unread_blog').remove();
        }
    });
};

$('document').ready(function () {
    return getUnreadBlogPosts();
});
