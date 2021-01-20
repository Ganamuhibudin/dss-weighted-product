@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Data Pelanggan</h3>
            </div>
            @if(isset($customer['id']))
            <form id="customer-form" method="put" action="{{ url('/customers') }}/{{ $customer['id'] }}" class="form-horizontal">
            @else
            <form id="customer-form" method="post" action="{{ url('/customers') }}" class="form-horizontal">
            @endif
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="code" class="col-sm-2 col-form-label">Kode</label>
                        <div class="col-sm-10">
                            <input type="text" name="code" class="form-control" id="code" value="{{ $customer['code'] ?? '' }}" placeholder="Kode">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="name" value="{{ $customer['name'] ?? '' }}" placeholder="Nama Pelanggan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <textarea name="address" class="form-control" rows="3" placeholder="Alamat">{{ $customer['address'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone" class="form-control" id="phone" value="{{ $customer['phone'] ?? '' }}" placeholder="Telepon">
                        </div>
                    </div>
                    <div id="message"></div>
                </div>
                <div class="card-footer">
                    <button type="button" id="save-customer" class="btn btn-info">Simpan</button>
                    <a href="{{ url('/customers') }}" class="btn btn-default">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
<script>
    $('#save-customer').on('click', function(e){
        var data = $('#customer-form').serialize();
        $.ajax({
            url: $('#customer-form').attr('action'),
            type: $('#customer-form').attr('method'),
            data: data,
            success: function(response) {
                $('#message').html('');
                location.href = "{{ url('/customers') }}";
            },
            error: function (request, error) {
                $('#message').html('<div class="alert alert-danger" role="alert">Simpan Data Gagal! Silahkan periksa kembali data yang anda inputkan</div>')
            }
        });
        e.preventDefault();
    });
</script>
@stop