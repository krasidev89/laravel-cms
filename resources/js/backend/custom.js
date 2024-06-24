/**
 * Function that initializes a image after upload.
 */
$(function () {
    $('[type="file"]').on('change', function (e) {
        var url = URL.createObjectURL(e.target.files[0]);

        $(this).parent().find('img').attr('src', url);
        URL.revokeObjectURL(url);
    });
});

/**
 * Function that initializes a button to delete text in an input field.
 */
$(function () {
    $('.btn-clear').on('click', function () {
        $(this).closest('.has-clear').find('input[type="text"]').val('').trigger('propertychange').focus();
    });
});

/**
 * Function that initializes a search box in collapse.
 */
$(function () {
    $('.searchbar').on('input propertychange', function () {
        var element = $(this);
        var text = element.val().toUpperCase();
        var uls = $(element.data('target') + ' ul');

        if (text != '') {
            uls.find('a').map(function () {
                if (this.text.trim().toUpperCase().indexOf(text) > -1) {
                    var parentItems = $(this).parents('li');

                    parentItems.find('[data-toggle="collapse"]').removeClass('collapsed').attr('aria-expanded', true);
                    parentItems.removeClass('d-none').find('.collapse').addClass('show');
                } else {
                    var link = $(this);

                    if (link.attr('data-toggle') == 'collapse') {
                        link.addClass('collapsed').attr('aria-expanded', false);
                    }

                    link.parent().addClass('d-none').find('.collapse').removeClass('show');
                }
            });
        } else {
            var ulsItems = uls.find('li');
            var parentItems = uls.find('a.active').parents('li');

            ulsItems.removeClass('d-none');
            ulsItems.find('[data-toggle="collapse"].default-expanded').removeClass('collapsed').attr('aria-expanded', true).closest('li').find('.collapse').addClass('show');
            ulsItems.find('[data-toggle="collapse"]:not(.default-expanded)').addClass('collapsed').attr('aria-expanded', false).closest('li').find('.collapse').removeClass('show');

            parentItems.find('[data-toggle="collapse"]').removeClass('collapsed').attr('aria-expanded', true);
            parentItems.find('.collapse').addClass('show');
        }
    });
});

/**
 * Function that initializes a blur effect on main content when side nav is open on a mobile resolution.
 */
$(function () {
    var buttonSideNavbarNav = $('[data-target="#sideNavbarContent"]');
    var sideNavbar = $('#sideNavbarContent');
    var main = $('#backend main');

    sideNavbar.on('show.bs.collapse hide.bs.collapse', function (e) {
        if ($(this).is(e.target)) {
            main.toggleClass('blur', !$(this).hasClass('show'));
        }
    });

    main.on('click', function () {
        if (buttonSideNavbarNav.is(':visible') && sideNavbar.is(':visible')) {
            sideNavbar.collapse('hide');
        }
    });
});
