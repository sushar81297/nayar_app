@extends('layouts.app')

@section('content')
<section class="content">
    <div class="row justify-content-end">
        <div class="col-lg-6">
            <b class="control-label">{{$page_name}}</b>
        </div>
        <div class="col-lg-4">
            <div class="input-group input-group-outline">
                <input type="date" class="form-control" name="searchDate">
            </div>
        </div>
        <div class="col-lg-2">
            <a href="{{ route('post_create', $page_id) }}">
                <button class="btn btn-outline-primary btn-sm mb-0 me-3">Create Post</button>
            </a>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-6">
            <div id="chart-container"></div>
        </div>
        <div class="col-lg-6">
            <div id="bar-chart-container"></div>
        </div>
    </div>

    <div class="row mb-5 mt-3">

        <div class="col-lg-6">
            <div id="container"></div>
        </div>
        <div class="col-lg-6">
            <div id="pie-container"></div>
        </div>
    </div>

    @forelse ($posts as $post)
    <div class="col-lg-12 col-md-6 mb-4">
        <div class="card">
            <div class="card-header">{{$post->message}}</div>
            <div class="card-body">
                <p>Total Like Count : <b>{{$post->likes}}</b> Total Comment Count : <b>{{$post->comments}}</b> </p>
                <p>Created Time : <b>{{$post->created_time}}</b></p>
                @if($post->images)
                @forelse ($post->images as $key => $value)
                <img src="{{$value}}" width="200px" />
                @empty
                @endforelse
                @elseif($post->image)
                <img src="{{$post->image}}" width="200px" />
                @endif
                <br>
                <a href="/post/delete/{{$post->post_id}}" type="button" class="btn btn-danger btn-xs">Delete</a>
            </div>
        </div>
    </div>
    @empty
    @endforelse

    <script>
        // Sample data for the chart
        // Create the chart
        // $.ajax({
        //     url: '/placeByDate',
        //     type: 'get',
        //     success: function(response) {
        Highcharts.chart('chart-container', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Post List (Weekly)',
            },
            xAxis: {
                categories: ['2023-11-22', '2023-11-23', '2023-11-24'],
            },
            series: [{
                data: [10, 11, 11]
            }, ]
        });
        //     }
        // });


        // Create the bar chart
        Highcharts.chart('bar-chart-container', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Browser market shares. January, 2022'
            },
            subtitle: {
                align: 'left',
                text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total percent market share'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },

            series: [{
                name: 'Browsers',
                colorByPoint: true,
                data: [{
                        name: 'Safari',
                        y: 19.84,
                        drilldown: 'Safari'
                    },
                    {
                        name: 'Firefox',
                        y: 4.18,
                        drilldown: 'Firefox'
                    },
                    {
                        name: 'Edge',
                        y: 4.12,
                        drilldown: 'Edge'
                    }
                ]
            }],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
                series: [{
                        name: 'Firefox',
                        id: 'Firefox',
                        data: [
                            [
                                'v58.0',
                                1.02
                            ],
                            [
                                'v57.0',
                                7.36
                            ],
                            [
                                'v56.0',
                                0.35
                            ],
                            [
                                'v55.0',
                                0.11
                            ],
                            [
                                'v54.0',
                                0.1
                            ],
                            [
                                'v52.0',
                                0.95
                            ],
                            [
                                'v51.0',
                                0.15
                            ],
                            [
                                'v50.0',
                                0.1
                            ],
                            [
                                'v48.0',
                                0.31
                            ],
                            [
                                'v47.0',
                                0.12
                            ]
                        ]
                    },
                    {
                        name: 'Internet Explorer',
                        id: 'Internet Explorer',
                        data: [
                            [
                                'v11.0',
                                6.2
                            ],
                            [
                                'v10.0',
                                0.29
                            ],
                            [
                                'v9.0',
                                0.27
                            ],
                            [
                                'v8.0',
                                0.47
                            ]
                        ]
                    },
                    {
                        name: 'Safari',
                        id: 'Safari',
                        data: [
                            [
                                'v11.0',
                                3.39
                            ],
                            [
                                'v10.1',
                                0.96
                            ],
                            [
                                'v10.0',
                                0.36
                            ],
                            [
                                'v9.1',
                                0.54
                            ],
                            [
                                'v9.0',
                                0.13
                            ],
                            [
                                'v5.1',
                                0.2
                            ]
                        ]
                    }
                ]
            }
        });


        // Create the pie chart
        const colors = Highcharts.getOptions().colors.map((c, i) =>
            Highcharts.color(Highcharts.getOptions().colors[0])
            .brighten((i - 3) / 7)
            .get()
        );
        Highcharts.chart('pie-container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Browser market shares in February, 2022',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    colors,
                    borderRadius: 5,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                        distance: -50,
                        filter: {
                            property: 'percentage',
                            operator: '>',
                            value: 4
                        }
                    }
                }
            },
            series: [{
                name: 'Share',
                data: [{
                        name: 'Chrome',
                        y: 74.03
                    },
                    {
                        name: 'Edge',
                        y: 12.66
                    },
                    {
                        name: 'Firefox',
                        y: 4.96
                    },
                    {
                        name: 'Safari',
                        y: 2.49
                    },
                    {
                        name: 'Internet Explorer',
                        y: 2.31
                    },
                    {
                        name: 'Other',
                        y: 3.398
                    }
                ]
            }]
        });

        // Create chart
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Column chart with negative values'
            },
            xAxis: {
                categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                column: {
                    borderRadius: '25%'
                }
            },
            series: [{
                name: 'John',
                data: [5, 3, 4, 7, 2]
            }, {
                name: 'Jane',
                data: [2, -2, -3, 2, 1]
            }, {
                name: 'Joe',
                data: [3, 4, 4, -2, 5]
            }]
        });
    </script>
</section>
@endsection