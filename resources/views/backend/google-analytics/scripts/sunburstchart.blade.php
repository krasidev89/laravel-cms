<script>
    function sunburstChart(select, data) {
        $(select + ' > *').remove();
        $('.nvtooltip').remove();

        nv.addGraph(function () {
            var chart = nv.models.sunburstChart()
                .mode('value')
                .margin({
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                });

            d3.select(select).datum([data]).call(chart);

            nv.utils.windowResize(chart.update);

            return chart;
        });
    }
</script>
