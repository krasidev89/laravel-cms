@include('scripts.bootstrap-datepicker')
<script>
    var inputStartDate = $('#start_date');
    var inputStartDateContainer = '#container_start_date';
    var inputEndDate = $('#end_date');
    var inputEndDateContainer = '#container_end_date';
    var maxEndDate = new Date();

    inputStartDate.datepicker({
        container: inputStartDateContainer,
        endDate: maxEndDate
    }).on('changeDate', function(selected) {
        var date = new Date(selected.date.valueOf());

        inputEndDate.datepicker('setStartDate', date);

        if (!inputEndDate.val()) {
            inputEndDate.datepicker('setDate', date);
        }
    });

    inputEndDate.datepicker({
        container: inputEndDateContainer,
        endDate: maxEndDate
    }).on('changeDate', function(selected) {
        var date = new Date(selected.date.valueOf());

        inputStartDate.datepicker('setEndDate', date);

        if (!inputStartDate.val()) {
            inputStartDate.datepicker('setDate', date);
        }
    });

    $(inputStartDateContainer + ' .btn-clear').on('click', function() {
        inputStartDate.val('').datepicker('update');
        inputEndDate.datepicker('setStartDate', null);
    });

    $(inputEndDateContainer + ' .btn-clear').on('click', function() {
        inputEndDate.val('').datepicker('update');
        inputStartDate.datepicker('setEndDate', maxEndDate);
    });
</script>
