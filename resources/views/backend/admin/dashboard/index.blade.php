@extends('backend.admin.layouts.app')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item active"><span>{{ __('message.dashboard') }}</span></li>
    </ol>
</nav>
@endsection

@section('content')
    <div class="container-lg px-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="">{{ __('message.orders') }}</h5>
                        <div>
                            <select class="form-select form-select-sm chart-current-duration">
                                <option value="weekly">{{ translate('Weekly', 'အပတ်စဥ်') }}</option>
                                <option value="monthly">{{ translate('Monthly', 'လစဥ်') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-body">
                        <canvas id="orderLineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('message.order_statuses') }}</h5>
                    <div class="card-body">
                        <canvas id="orderPieChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('message.stock_quantity') }}</h5>
                    <div class="card-body">
                        <canvas id="productStockQuantityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('chartjs/chart.js') }}"></script>

    <script>
        $(document).ready(function() {
            const Utils = {
                months: function({count}) {
                    const months = [];
                    const date = new Date();

                    for (let i = 0; i < count; i++) {
                        months.unshift(date.toLocaleString('default', { month: 'long' }));
                        date.setMonth(date.getMonth() - 1);
                    }

                    return months;
                }
            };


            // product stock quantity chart --- start
            const ctx = document.getElementById('productStockQuantityChart').getContext('2d');
            const stockChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($products_stock_quantity_ary['name']),
                    datasets: [{
                        label: 'Stock Quantity',
                        data: @json($products_stock_quantity_ary['stock_quantity']),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            // product stock quantity chart --- end

            // order pie chart --- start
            new Chart(document.getElementById('orderPieChart'), {
                type: 'pie',
                data: {
                    labels: [
                        'Pending',
                        'Confirm',
                        'Cancel'
                    ],
                    datasets: [{
                        label: 'Order',
                        data: @json($order_status_count_ary),
                        backgroundColor: [
                            'rgb(249, 177, 21)',
                            'rgb(27, 158, 62)',
                            'rgb(229, 83, 83)'
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            // order pie chart --- end

            // order line chart --- start
            var orderLineChart = new Chart(document.getElementById('orderLineChart'), {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: 'Order',
                            data: [],
                            fill: false,
                            borderColor: 'rgb(51, 153, 255)',
                            tension: 0.1
                        }
                    ]
                },
            });

            getOrderLineChart('weekly');

            $(document).on('change', '.chart-current-duration', function () {
                let chart_current_duration = $(this).val();
                console.log(chart_current_duration);

                getOrderLineChart(chart_current_duration);
            });

            function getOrderLineChart(chart_current_duration) {
                $.get('/admin/get-order-chart-data', {
                        chart_current_duration
                    })
                    .then(function(res) {
                        if (res.success == 1) {
                            orderLineChart.data.labels = res.data.dates;
                            orderLineChart.data.datasets[0].data = res.data.counts;

                            orderLineChart.update();

                            console.log(res.message);
                        } else {
                            toastr.warning(res.message);
                        }
                    }).fail(function(error) {
                        toastr.error(error.message);
                    });
            }
            // order line chart --- end
        });
    </script>
@endsection
