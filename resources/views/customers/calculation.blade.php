@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

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
    </div>
</div>
@stop

@section('css')
<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
<script>
    $(function () {
        
    });
</script>
@stop