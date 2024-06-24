<script>
    function createChart(data) {
        $('#area-visitors-and-pageviews').highcharts({
            accessibility: {
                enabled: false
            },
            xAxis: {
                categories: JSON.parse(data.categories)
            },
            yAxis: [{
                title: {
                    text: '{{ __('Visitors') }}',
                }
            }, {
                title: {
                    text: '{{ __('Page Views') }}',
                },
                opposite: true
            }],
            series: [{
                name: '{{ __('Visitors') }}',
                data: JSON.parse(data.visitors)
            }, {
                name: '{{ __('Page Views') }}',
                data: JSON.parse(data.pageviews)
            }]
        });
    }
</script>
