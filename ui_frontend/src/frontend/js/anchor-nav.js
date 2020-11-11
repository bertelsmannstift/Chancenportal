$(document).ready(function() {
    $('a[href^="#"]').click(function (e) {
        if($(this).attr('href').length > 1 && $($(this).attr('href')).length) {
            e.preventDefault();
            $('html, body').stop().animate({
                'scrollTop':  $($(this).attr('href')).offset().top
            }, 300);
        }
    });
});
