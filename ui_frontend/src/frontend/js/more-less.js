window.initToggle = () => {
    let $triggers = $('[data-more-items]');
    $triggers.each(function () {
        let $moreItems = $($(this).data('more-items'));
        let $lessItems = $($(this).data('less-items'));

        $(this).unbind('click').click(function (e) {
            e.preventDefault();
            $moreItems.toggle();
            $lessItems.toggle();
        });

        $moreItems.hide();
        $lessItems.show();
    });
};
window.initToggle();
