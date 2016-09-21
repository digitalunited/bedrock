$(document).ready(function () {
    $('.component-slider').slick({
        dots: true,
        arrows: true,
        focusOnSelect: false,
        draggable: false,
        adaptiveHeight: true,
        fade: true,
        autoplay: false,
        autoPlayTimer: 500,
        prevArrow: '<span class="icon icon-chevron-left prev-slide"></span>',
        nextArrow: '<span class="icon icon-chevron-right next-slide"></span>'
    });
});
