@extends('adminlte::page')

@section('title', 'List Sub Kriteria')

@section('plugins.Datatables', true)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Data Sub Kriteria - {{ $criteria['code'] }}({{ $criteria['name'] }})</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div id="formSubKriteria" style="display:none;">
                    <h5>Form Sub Kriteria</h5>
                    <hr>
                    <form id="form-sub-criteria" action="/criteria/sub-add" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama Sub Kriteria</label>
                            <div class="col-sm-5">
                                <input type="hidden" name="criteria_id" value="{{ $criteria['id'] }}" />
                                <input type="text" name="name" class="form-control" id="name" placeholder="Input Nama Sub Kriteria">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="value" class="col-sm-2 col-form-label">Bobot</label>
                            <div class="col-sm-5">
                                <input type="number" name="value" class="form-control" id="value" placeholder="Input Bobot">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <button type="button" id="save-sub-criteria" class="btn btn-sm btn-info">Simpan</button> &nbsp;
                                <button type="button" id="cancel-form-subkriteria"  class="btn btn-sm btn-default">Batal</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                </div>
                <div class="col-sm-2">
                    <button id="btnAddSubKriteria" class="btn btn-block btn-primary btn-sm" style="color: white;">Tambah Data</button>
                </div>
                <br>
                <table id="tblSubCriterias" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th width="50%">Nama Sub Kriteria</th>
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
        const urlData = "{{ url('/criteria') }}/list-sub/{{ $criteria['id'] }}";
        $("#tblSubCriterias").DataTable({
            "responsive": true,
            "autoWidth": false,
            "ajax": {
                "url": urlData,
                "dataSrc": ""
            },
            "columns": [
                { "data": "no" },
                { "data": "name" },
                { "data": "value" },
                { "data": "action" }
            ]
        });

        $("#tblSubCriterias").on("click",".btn-edit", function(){
            const urlEdit = $(this).attr('url');
            console.log(urlEdit);
            // return false;
            $.ajax({
                url: urlEdit,
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    $("#formSubKriteria").show();
                    $("#form-sub-criteria #name").val(result.name);
                    $("#form-sub-criteria #value").val(result.value);
                    $('#form-sub-criteria').attr('action', "/criteria/sub/" + result.id)
                    $("#form-sub-criteria").attr("method", "put");
                }
            });
        });

        $("#tblSubCriterias").on("click",".btn-delete", function(){
            const urlDelete = $(this).attr('url');
            $.ajax({
                url: urlDelete,
                type: 'DELETE',
                data:{
                    '_token': '{{ csrf_token() }}',
                },
                success: function(result) {
                    location.href = urlData;
                }
            });
        });

        // show form sub criteria
        $("#btnAddSubKriteria").on("click", function(){
            $("#formSubKriteria").show();
            $("#form-sub-criteria #name").val('');
            $("#form-sub-criteria #value").val('');
            $('#form-sub-criteria').attr('action', "/criteria/sub-add")
            $("#form-sub-criteria").attr("method", "post");
        });

        // hide form criteria
        $("#cancel-form-subkriteria").on("click", function(){
            $("#formSubKriteria").hide();
        });

        // submit form criteria
        $('#save-sub-criteria').on('click', function(e){
            var data = $('#form-sub-criteria').serialize();
            $.ajax({
                url: $('#form-sub-criteria').attr('action'),
                type: $('#form-sub-criteria').attr('method'),
                data: data,
                success: function(response) {
                    location.href = urlData;
                },
                error: function (request, error) {
                    return false;
                }
            });
            e.preventDefault();
        });
        
    });
</script>
@stop