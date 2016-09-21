$('.logo-wrapper').slick({
    dots: true,
    infinite: true,
    speed: 300,
    arrows: false,
    slidesToShow: 5,
    slidesToScroll: 5,
    respondTo: 'slider',
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
                infinite: true,
                dots: true
            }
        }, {
            breakpoint: 700,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3
            }
        }, {
            breakpoint: 480,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        }
    ]
});
