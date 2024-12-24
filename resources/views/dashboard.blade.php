@extends('layout.manage')


@section('title', 'Dashboard')


@push('styles')
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            @if (Auth::user()->role != 'Goverment')
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $reportPendingCount }}</h3>
                            <p>Laporan Pending</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-clock-outline"></i>
                        </div>
                        <a href="{{ route('reports') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $reportVerifiedCount }}</h3>
                            <p>Laporan Terverifikasi</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-checkmark-circled"></i>
                        </div>
                        <a href="{{ route('reports') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $reportInProgressCount }}</h3>
                            <p>Laporan Sedang di Proses</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-gear-outline"></i>
                        </div>
                        <a href="{{ route('reports') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $reportCompletedCount }}</h3>
                            <p>Laporan Selesai</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-checkmark-outline"></i>
                        </div>
                        <a href="{{ route('reports') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @else
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $reportVerifiedCount }}</h3>
                            <p>Laporan Menunggu di Proses</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-clock-outline"></i>
                        </div>
                        <a href="{{ route('reports') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $reportInProgressCount }}</h3>
                            <p>Laporan Sedang di Proses</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-gear-outline"></i>
                        </div>
                        <a href="{{ route('reports') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $reportCompletedCount }}</h3>
                            <p>Laporan Selesai</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-checkmark-outline"></i>
                        </div>
                        <a href="{{ route('reports') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endif
        </div>
        @if (Auth::user()->role == 'Goverment' || Auth::user()->role == 'Admin')
            <div class="row">
                <div class="col-md-6">
                    <!-- AREA CHART -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Jumlah Laporan @if (Auth::user()->role == 'Goverment')
                                    - {{ Auth::user()->region }}
                                @endif {{ now()->year }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="areaChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Kategori Laporan @if (Auth::user()->role == 'Goverment')
                                    - {{ Auth::user()->region }}
                                @endif {{ now()->year }}
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        @endif
        @if (Auth::user()->role == 'Admin')
            <div class="row">
                <div class="col-md-6">
                    <!-- BAR CHART -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Jumlah Laporan Berdasarkan Wilayah {{ now()->year }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <!-- BAR CHART -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Jumlah User {{ now()->year }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="lineChart1"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        @endif
    </div>
@endsection

@push('script')
    <!-- ChartJS -->
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/chart.js/Chart.min.js"></script>
    @if (Auth::user()->role == 'Goverment' || Auth::user()->role == 'Admin')
        <script>
            $(function() {
                var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
                // Ambil data dari PHP yang sudah dikirim ke view
                var reportDataByMonth = @json($reportDataByMonth);


                var areaChartData = {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                        'October', 'November', 'December'
                    ],
                    datasets: [{
                        label: 'Laporan Masuk',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: reportDataByMonth
                    }, ]
                }

                var areaChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }]
                    }
                }

                // This will get the first returned node in the jQuery collection.
                new Chart(areaChartCanvas, {
                    type: 'line',
                    data: areaChartData,
                    options: areaChartOptions
                })


                // Ambil data dari PHP yang sudah dikirim ke view
                var reportsByCategory = @json($reportsByCategory);

                // Pisahkan label dan data untuk chart
                var labels = Object.keys(reportsByCategory); // Nama kategori
                var data = Object.values(reportsByCategory); // Jumlah laporan per kategori

                var pieChartCanvas = $('#pieChart').get(0).getContext('2d');

                var pieData = {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'
                        ]
                    }]
                };
                var pieOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                };
                // Render pie chart
                new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: pieData,
                    options: pieOptions
                });
            })
        </script>
    @endif

    @if (Auth::user()->role == 'Admin')
        <script>
            // Ambil data dari PHP yang sudah dikirim ke view
            var reportsByRegion = @json($reportsByRegion);

            // Pisahkan label dan data untuk chart
            var labels = Object.keys(reportsByRegion); // Nama region
            var data = Object.values(reportsByRegion); // Jumlah laporan per region

            var barChartCanvas = $('#barChart').get(0).getContext('2d');

            var barData = {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Laporan per Region',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    data: data
                }]
            };

            var barOptions = {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        gridLines: {
                            display: false,
                        }
                    }]
                }
            };

            // Render bar chart
            new Chart(barChartCanvas, {
                type: 'bar', // Bisa juga diganti 'horizontalBar' untuk chart horizontal
                data: barData,
                options: barOptions
            });

            var governmentData = @json($governmentData);
            var citizenData = @json($citizenData);

            var lineChartCanvas = $('#lineChart1').get(0).getContext('2d');

            var lineData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                    'October', 'November', 'December'
                ],
                datasets: [{
                        label: 'Government Users',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        data: governmentData,
                        fill: false,
                    },
                    {
                        label: 'Citizen Users',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        data: citizenData,
                        fill: false,
                    }
                ]
            };

            var lineOptions = {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        gridLines: {
                            display: false,
                        }
                    }]
                }
            };

            // Render line chart
            new Chart(lineChartCanvas, {
                type: 'line', // Bisa juga 'bar' untuk bar chart
                data: lineData,
                options: lineOptions
            });
        </script>
    @endif
@endpush
