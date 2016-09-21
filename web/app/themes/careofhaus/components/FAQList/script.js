$(document).ready(function () {

    $('.faq_question').on('click', function (e) {
        var open,
            li = $(this).parent(li);
        e.preventDefault();
        open = li.hasClass('active');

        $('.faq_item').removeClass('active');

        if (open) {
            li.removeClass('active');
        } else {
            li.addClass('active');
        }

    });
});
