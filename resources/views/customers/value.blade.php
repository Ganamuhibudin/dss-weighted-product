@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Nilai Pelanggan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="col-sm-2">
                    <a href="{{ url('/customer-value/create') }}" class="btn btn-block btn-primary btn-sm" style="color: white;">Tambah Data</a>
                </div>
                <br>
                <table class="table table-bordered">
                    <thead>                  
                        <tr>
                            <th>Kode</th>
                            <th>Nama Pelanggan</th>
                            @foreach ($criterias as $criteria)
                                <th>{{ $criteria['code'] }}</th>
                            @endforeach
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($customerValues as $customerValue)
                        <tr>
                            <td>{{ $customerValue['customer']['code'] }}</td>
                            <td>{{ $customerValue['customer']['name'] }}</td>
                            @foreach ($customerValue['values'] as $val)
                                <td>{{ $val['value'] }}</td>
                            @endforeach
                            <td>
                            <a href="{{ url('/customer-value') }}/{{ $customerValue['customer']['id'] }}" class="btn btn-block btn-warning btn-sm" style="color: white;"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
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