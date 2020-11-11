window.initTogglShow = () => {
    let $items = $('[data-toggle-show-item]');

    $items.each(function () {
        $(this).unbind('click').click(function (e) {
            e.preventDefault();
            let activeClass = $(this).data('toggle-class');
            $(this).toggleClass(activeClass);
            let show = $($(this).data('toggle-show-item')).attr('show') === 'true';
            if(show) {
                $($(this).data('toggle-show-item')).attr('show', false);
            } else {
                $($(this).data('toggle-show-item')).attr('show', true);
            }
        });
    });
};
window.initTogglShow();
