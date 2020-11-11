let link = document.referrer.split('/');

if (link.length >= 4) {
    if(link[3] !== 'angebote' && link[3] !== 'anbieter') {
        $('.info-nav__backlink').hide();
    }
} else {
    $('.info-nav__backlink').hide();
}

$('.info-nav__backlink').click(function(e) {
    e.preventDefault();
    if(document.referrer.indexOf(window.location.host) >= 0) {
        window.history.back();
        return false;
    }
});
