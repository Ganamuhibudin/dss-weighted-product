@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Data Kriteria</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="col-sm-2">
                    <a href="{{ url('/criteria/create') }}" class="btn btn-block btn-primary btn-sm" style="color: white;">Tambah Data</a>
                </div>
                <br>
                <table id="tblCriterias" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="10%">Kode</th>
                        <th width="30%">Nama Kriteria</th>
                        <th width="15%">Atribut</th>
                        <th width="20%">Bobot</th>
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
        const urlData = "{{ url('/criteria') }}";
        $("#tblCriterias").DataTable({
            "responsive": true,
            "autoWidth": false,
            "ajax": {
                "url": urlData,
                "dataSrc": ""
            },
            "columns": [
                { "data": "code" },
                { "data": "name" },
                { "data": "atribut" },
                { "data": "weight" },
                { "data": "action" }
            ]
        });

        $("#tblCriterias").on("click",".btn-delete", function(){
            const urlDelete = $(this).attr('url');
            $.ajax({
                url: urlDelete,
                type: 'DELETE',
                data:{
                    '_token': '{{ csrf_token() }}',
                },
                success: function(result) {
                    location.href = "{{ url('/criteria') }}";
                }
            });
        });
    });
</script>
@stop