@extends('adminlte::page')

@section('title', 'Laporan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Laporan Pelanggan Terbaik</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="col-sm-3">
                    Laporan Data Pelanggan Terpilih
                </div>
                <div class="col-sm-2">
                    <a href="{{ url('/report-rank') }}" class="btn btn-block btn-primary btn-sm" style="color: white;">Cetak Laporan</a>
                </div>
                <br>
                <div class="col-sm-3">
                    Laporan Data Keseluruhan
                </div>
                <div class="col-sm-2">
                    <a href="{{ url('/report-all') }}" class="btn btn-block btn-primary btn-sm" style="color: white;">Cetak Laporan</a>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@stop