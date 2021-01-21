@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)
@section('plugins.Chartjs', true)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Perhitungan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table width="100%">
                    <tr>
                        <td width="50%">
                            <div class="col-sm-6">
                                <h5 class="card-title">Data Kriteria</h5>
                            </div>
                            <br>
                            <table class="table table-bordered">
                                <thead>                  
                                    <tr>
                                        <th>Kriteria</th>
                                        <th>Nama Kriteria</th>
                                        <th>Nilai Bobot</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                $totalNilaiKriteria = 0;
                                @endphp
                                @foreach ($criterias as $criteria)
                                    @php
                                    $totalNilaiKriteria = $totalNilaiKriteria + $criteria['weight'];
                                    @endphp
                                    <tr>
                                        <td>{{ $criteria['code'] }}</td>
                                        <td>{{ $criteria['name'] }}</td>
                                        <td>{{ $criteria['weight'] }}</td>
                                    </tr>
                                @endforeach
                                    <tr>
                                        <td colspan="2" style="text-align:right;">Total</td>
                                        <td>{{ $totalNilaiKriteria }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="50%">
                            <div class="col-sm-6">
                                <h5 class="card-title">Normalisasi Bobot</h5>
                            </div>
                            <br>
                            <table class="table table-bordered">
                                <thead>                  
                                    <tr>
                                        <th>Bobot</th>
                                        <th>Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($normalisasiBobot as $val)
                                    <tr>
                                        <td>{{ $val['code'] }}</td>
                                        <td>{{ $val['value'] }}</td>
                                    </tr>
                                @endforeach
                                    <tr>
                                        <td>&Sigma;W</td>
                                        <td>{{ $totalBobot }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <br>
                <table width="100%">
                    <tr>
                        <td width="50%">
                            <div class="col-sm-6">
                                <h5 class="card-title">Nilai Vector S</h5>
                            </div>
                            <br>
                            <table class="table table-bordered">
                                <tbody>
                                @php
                                $i = 0;
                                @endphp
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ str_replace("A", "S", $customer['code']) }}</td>
                                        <td>{{ $nilaiVectorS[$i] }}</td>
                                    </tr>
                                    @php
                                    $i++;
                                    @endphp
                                @endforeach
                                    <tr>
                                        <td>Total</td>
                                        <td>{{ $totalVectorS }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="50%">
                            <div class="col-sm-6">
                                <h5 class="card-title">Nilai Vector V</h5>
                            </div>
                            <br>
                            <table class="table table-bordered">
                                <tbody>
                                @php
                                $i = 0;
                                @endphp
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ str_replace("A", "S", $customer['code']) }}</td>
                                        <td>{{ $nilaiVectorV[$i] }}</td>
                                    </tr>
                                    @php
                                    $i++;
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <br>
                <div class="col-sm-6">
                    <h5 class="card-title">Hasil</h5>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>Nilai</th>
                            <th>Rank</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer['name'] }}</td>
                            <td>{{ $nilaiVectorV[$i] }}</td>
                            <td>{{ array_search($nilaiVectorV[$i], $rank) + 1 }}</td>
                        </tr>
                        @php
                        $i++;
                        @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- BAR CHART -->
        <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Chart Hasil Perhitungan</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
    </div>
</div>
@stop

@section('css')
<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
<script>
    $(function () {
        var customers = <?php echo json_encode($customers); ?>;
        var nilaiVectorV = <?php echo json_encode($nilaiVectorV); ?>;

        var barLabels = [];
        var barData = [];
        var i = 0;
        for (var key in customers) {
            if (customers.hasOwnProperty(key)) {
                barLabels.push(customers[key]['name']);
                barData.push(nilaiVectorV[i]);
            }
            i++;
        }

        var areaChartData = {
            labels  : barLabels,
            datasets: [
                {
                    label               : 'Pelanggan',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : barData
                },
            ]
        }

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = jQuery.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        barChartData.datasets[0] = temp0

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false,
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                    }
                }]
            }
        }

        var barChart = new Chart(barChartCanvas, {
            type: 'bar', 
            data: barChartData,
            options: barChartOptions
        })
    });
</script>
@stop