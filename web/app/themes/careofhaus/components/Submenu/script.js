$('.component-submenu .navigation-select').click(function () {
    $('.component-submenu .navigation').slideToggle(200);
    $('.component-submenu .navigation-select').toggleClass('active');
    return false;
});
