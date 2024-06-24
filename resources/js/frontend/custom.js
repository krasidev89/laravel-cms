/**
 * jQuery columnCount plugin
 */
(function ($) {
    $.fn.columnCount = function (options) {
        var gridBreakpoints = {
            xl: '(min-width: 1200px)',
            lg: '(min-width: 992px)',
            md: '(min-width: 768px)',
            sm: '(min-width: 576px)'
        };

        var counts = $.extend({
            xl: 0, lg: 0, md: 0, sm: 0, xs: 1
        }, options);

        var breakpoints = [];
        var maxColumnCount = 1;

        for (i in counts) {
            if (counts[i] && i != 'xs') {
                breakpoints.push({
                    media: window.matchMedia(gridBreakpoints[i]),
                    count: counts[i]
                });

                if (counts[i] > maxColumnCount) {
                    maxColumnCount = counts[i];
                }
            }
        }

        return this.each(function () {
            var row = $(this);
            var cols = row.find('> [class*="col"]');
            var prependCols = '';

            for (var c = 0; c < maxColumnCount; c++) {
                prependCols += '<div class="col d-none"><div class="row"></div></div>';
            }

            row.prepend(prependCols);

            function responsiveMedia() {
                var col = counts['xs'];

                for (var i in breakpoints) {
                    if (breakpoints[i]['media'].matches) {
                        col = breakpoints[i]['count'];
                        break;
                    }
                }

                if (typeof col !== 'undefined') {
                    row.find('> .col').removeClass('d-none');
                    row.find('> .col:nth-child(n+' + (col + 1) + ')').addClass('d-none');

                    for (var i = 0; i < cols.length; i++) {
                        $(cols[i]).appendTo(
                            row.find('> .col:nth-child(' + ((i % col) + 1) + ') > .row')
                        );
                    }
                }
            }

            for (var i in breakpoints) {
                breakpoints[i]['media'].addListener(responsiveMedia);
            }

            responsiveMedia();
        });
    };
})(jQuery);
