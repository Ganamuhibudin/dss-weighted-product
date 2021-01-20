@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Data Pelanggan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="col-sm-2">
                    <a href="{{ url('/customers/create') }}" class="btn btn-block btn-primary btn-sm" style="color: white;">Tambah Data</a>
                </div>
                <br>
                <table id="tblCustomers" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                        </tr>
                    </thead>
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
        const urlData = "{{ url('/customers') }}";
        $("#tblCustomers").DataTable({
            "responsive": true,
            "autoWidth": false,
            "ajax": {
                "url": urlData,
                "dataSrc": ""
            },
            "columns": [
                { "data": "code" },
                { "data": "name" },
                { "data": "address" },
                { "data": "phone" },
                { "data": "action" }
            ]
        });

        $("#tblCustomers").on("click",".btn-delete", function(){
            const urlDelete = $(this).attr('url');
            $.ajax({
                url: urlDelete,
                type: 'DELETE',
                data:{
                    '_token': '{{ csrf_token() }}',
                },
                success: function(result) {
                    location.href = "{{ url('/customers') }}";
                }
            });
        });
    });
</script>
@stop