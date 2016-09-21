var appendPosts;

$('.next a').click(function () {
    var $nextButton, nextPage;
    $nextButton = $(this);
    nextPage = $(this).attr('href');
    $nextButton.hide();
    $.get(nextPage, {}, function (res) {
        var $document, $nextPosts, $postListContainer, nextUrl;
        $document = $('<div>').html(res);
        $nextPosts = $document.find('.component-postlist .component-post');
        nextUrl = $document.find('.component-postlist .next a').attr('href');
        $postListContainer = $('.component-postlist .posts');
        $nextPosts.hide();
        $postListContainer.append($nextPosts);
        $postListContainer.find('.component-post').fadeIn();
        if (nextUrl) {
            $nextButton.attr('href', nextUrl);
            return $nextButton.fadeIn('fast');
        }
    });
    return false;
});

appendPosts = function ($nextPosts) {
};
