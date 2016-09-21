$('.sub-nav-toggle').on('click', function () {
    $(this).parent().toggleClass('open');
    return false;
});

$('#toggle-navigation').on('click', function () {
    if ($('.has-sub.open').last().hasClass('open')) {
        $('#mobile-back').trigger('click');
    }
    $('.main-nav, #toggle-navigation, .nav-controls').toggleClass('open');
    return false;
});

$('#counter .sub-nav-toggle').on('click', function () {
    var $counter, $navControl, lvl, newValue;
    $counter = $('#counter');
    $navControl = $('.nav-controls');
    lvl = $counter.data('lvl');
    newValue = lvl + 1;
    $counter.removeClass('lvl-' + lvl).addClass('lvl-' + newValue).data('lvl', newValue);
    $navControl.removeClass('lvl-' + lvl).addClass('lvl-' + newValue).data('lvl', newValue);
    return false;
});

$('#mobile-back').on('click', function () {
    var $counter, $navControl, lvl, newValue;
    $('.has-sub.open').last().removeClass('open');
    $counter = $('#counter');
    $navControl = $('.nav-controls');
    lvl = $counter.data('lvl');
    newValue = lvl - 1;
    $counter.removeClass('lvl-' + lvl).addClass('lvl-' + newValue).data('lvl', newValue);
    $navControl.removeClass('lvl-' + lvl).addClass('lvl-' + newValue).data('lvl', newValue);
    return false;
});
