$(window).on('scroll', function() {
    if ($(this).scrollTop() > 15) {
        if (!$('.navbar').hasClass('navbar-shadow')) {
            $('.navbar').addClass('navbar-shadow');
        }
    } else {
        if ($('.navbar').hasClass('navbar-shadow')) {
            $('.navbar').removeClass('navbar-shadow');
        }
    }
});