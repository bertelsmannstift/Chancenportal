window.initTabToggle = () => {
    let $tabs = $('[data-toggle-items]');
    $tabs.each(function () {
        $(this).unbind('click').click(function (e) {
            e.preventDefault();
            let activeClass = $(this).data('toggle-class');
            let $items = $($(this).data('toggle-items'));
            let $show = $($(this).data('toggle-show'));
            $items.hide();
            $show.show();

            //Reset Map
            if($show.find('custom-map').length && $show.find('custom-map').attr('show') === 'true') {
                $show.find('custom-map').get(0).getVueInstance().init();
            }

            $tabs.removeClass(activeClass);
            $(this).addClass(activeClass);
        });
        let activeClass = $(this).data('toggle-class');
        if ($(this).hasClass(activeClass)) {
            $(this).click();
        }
    });
};
window.initTabToggle();