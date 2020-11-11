$('body').on('submit', '.form-to-validate', function(event) {
    let valid = true;
    let $scrollTo = false;
    const $form = $(this);
    const $dropdowns = $form.find('.input__dropdown');
    let $datepicker = $form.find('custom-datepicker');
    let $inputs = $form.find('.input__field');

    $inputs = $inputs.filter(function() {
        return $(this).parents('custom-new-line').length === 0 || ($(this).parents('.custom-new-line__org_clone').length === 0 && $(this).parents('custom-new-line').length > 0 && $(this).parents('custom-new-line').is(':visible'))
    });

    $datepicker = $datepicker.filter(function() {
        return $(this).parents('custom-new-line').length === 0 || ($(this).parents('.custom-new-line__org_clone').length === 0 && $(this).parents('custom-new-line').length > 0 && $(this).parents('custom-new-line').is(':visible'))
    });

    $inputs.each(function() {
        const $input = $(this);
        const required = $input.attr('required');
        $input.removeClass('input--error');
        $input.closest('.input').removeClass('input--error');

        if (typeof required !== typeof undefined && required !== false && $input.val() === '') {
            valid = false;
            $input.addClass('input--error');
            $input.closest('.input').addClass('input--error');

            if(!$scrollTo) {
                $scrollTo = $input.offset().top - 150;
            }
        }
    });

    $dropdowns.each(function() {
        const $dropdown = $(this);
        const required = $dropdown.attr('required');
        const activeCount = $dropdown.find('.custom-dropdown__item--active').length;
        $dropdown.removeClass('input--error');
        $dropdown.closest('.input').removeClass('input--error');

        if (typeof required !== typeof undefined && required !== false && activeCount === 0) {
            valid = false;
            $dropdown.addClass('input--error');
            $dropdown.closest('.input').addClass('input--error');

            if(!$scrollTo) {
                $scrollTo = $dropdown.offset().top - 150;
            }
        }
    });

    $datepicker.each(function() {
        const $dp = $(this);
        const required = $dp.attr('required');
        const val = $dp.find('[type="text"]').val().trim();
        $dp.removeClass('input--error');
        $dp.closest('.input').removeClass('input--error');

        if (typeof required !== typeof undefined && required !== false && val.length === 0) {
            valid = false;
            $dp.addClass('input--error');
            $dp.closest('.input').addClass('input--error');

            if(!$scrollTo) {
                $scrollTo = $dp.offset().top - 150;
            }
        }
    });

    if(!valid) {
        $('html, body').stop().animate({
            scrollTop: $scrollTo
        }, 300);
    }

    return valid;
});