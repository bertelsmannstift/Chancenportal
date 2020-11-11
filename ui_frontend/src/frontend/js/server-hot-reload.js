let interval = setInterval(() => {
    if (document.hidden === false) {
        $.getJSON('/__server_hot.json?url=' + window.location.pathname, function (data) {
            if (data.reload) {
                window.location.reload();
            }
        });
    }
}, 1000);

$(window).on('beforeunload', function(){
    clearInterval(interval);
});
