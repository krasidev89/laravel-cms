<script>
    $.extend(true, $.fn.datetimepicker, {
        dates: {
            custom: {
                days: [
                    '{{ __('timestamp-pickers.days.sunday') }}',
                    '{{ __('timestamp-pickers.days.monday') }}',
                    '{{ __('timestamp-pickers.days.tuesday') }}',
                    '{{ __('timestamp-pickers.days.wednesday') }}',
                    '{{ __('timestamp-pickers.days.thursday') }}',
                    '{{ __('timestamp-pickers.days.friday') }}',
                    '{{ __('timestamp-pickers.days.saturday') }}',
                    '{{ __('timestamp-pickers.days.sunday') }}'
                ],
                daysShort: [
                    '{{ __('timestamp-pickers.daysShort.sun') }}',
                    '{{ __('timestamp-pickers.daysShort.mon') }}',
                    '{{ __('timestamp-pickers.daysShort.tue') }}',
                    '{{ __('timestamp-pickers.daysShort.wed') }}',
                    '{{ __('timestamp-pickers.daysShort.thu') }}',
                    '{{ __('timestamp-pickers.daysShort.fri') }}',
                    '{{ __('timestamp-pickers.daysShort.sat') }}',
                    '{{ __('timestamp-pickers.daysShort.sun') }}'
                ],
                daysMin: [
                    '{{ __('timestamp-pickers.daysMin.su') }}',
                    '{{ __('timestamp-pickers.daysMin.mo') }}',
                    '{{ __('timestamp-pickers.daysMin.tu') }}',
                    '{{ __('timestamp-pickers.daysMin.we') }}',
                    '{{ __('timestamp-pickers.daysMin.th') }}',
                    '{{ __('timestamp-pickers.daysMin.fr') }}',
                    '{{ __('timestamp-pickers.daysMin.sa') }}',
                    '{{ __('timestamp-pickers.daysMin.su') }}'
                ],
                months: [
                    '{{ __('timestamp-pickers.months.january') }}',
                    '{{ __('timestamp-pickers.months.february') }}',
                    '{{ __('timestamp-pickers.months.march') }}',
                    '{{ __('timestamp-pickers.months.april') }}',
                    '{{ __('timestamp-pickers.months.may') }}',
                    '{{ __('timestamp-pickers.months.june') }}',
                    '{{ __('timestamp-pickers.months.july') }}',
                    '{{ __('timestamp-pickers.months.august') }}',
                    '{{ __('timestamp-pickers.months.september') }}',
                    '{{ __('timestamp-pickers.months.october') }}',
                    '{{ __('timestamp-pickers.months.november') }}',
                    '{{ __('timestamp-pickers.months.december') }}'
                ],
                monthsShort: [
                    '{{ __('timestamp-pickers.monthsShort.jan') }}',
                    '{{ __('timestamp-pickers.monthsShort.feb') }}',
                    '{{ __('timestamp-pickers.monthsShort.mar') }}',
                    '{{ __('timestamp-pickers.monthsShort.apr') }}',
                    '{{ __('timestamp-pickers.monthsShort.may') }}',
                    '{{ __('timestamp-pickers.monthsShort.jun') }}',
                    '{{ __('timestamp-pickers.monthsShort.jul') }}',
                    '{{ __('timestamp-pickers.monthsShort.aug') }}',
                    '{{ __('timestamp-pickers.monthsShort.sep') }}',
                    '{{ __('timestamp-pickers.monthsShort.oct') }}',
                    '{{ __('timestamp-pickers.monthsShort.nov') }}',
                    '{{ __('timestamp-pickers.monthsShort.dec') }}'
                ],
                meridiem: [],
                suffix: [],
                today: '{{ __('timestamp-pickers.today') }}',
                clear: '{{ __('timestamp-pickers.clear') }}',
                weekStart: 0,
                format: '{!! implode(' ', config()->get(['app.date_format_javascript', 'app.time_format_javascript'])) !!}'
            }
        },
        defaults: {
            language: 'custom',
            pickerPosition: 'bottom-right',
            autoclose: true
        }
    });
</script>
