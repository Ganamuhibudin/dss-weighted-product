@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Penilaian Pelanggan</h3>
            </div>
            @if (isset($customerValues))
            <form id="customer-value-form" method="put" action="{{ url('/customer-value') }}/{{ $customerValues['customer']['id'] }}" class="form-horizontal">
            @else
            <form id="customer-value-form" method="post" action="{{ url('/customer-value') }}" class="form-horizontal">
            @endif
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                        <div class="col-sm-10">
                        @if (isset($customerValues))
                            <input type="text" readonly="" name="customer" class="form-control" id="customer" value="{{ $customerValues['customer']['code'] }} - {{ $customerValues['customer']['name'] }}">
                        @else
                            <select class="form-control" name="customer">
                                <option value="">Pilih Perusahaan</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer['id'] }}">{{ $customer['code'] }} - {{ $customer['name'] }}</option>
                            @endforeach
                            </select>
                        @endif
                        </div>
                    </div>
                    @foreach ($criterias as $criteria)
                    <div class="form-group row">
                        <label for="{{ $criteria['code'] }}" class="col-sm-2 col-form-label">{{ $criteria['code'] }}</label>
                        <div class="col-sm-10">
                        @if (isset($customerValues))
                            <input type="number" name="values[{{ $criteria['id'] }}]" class="form-control" id="{{ $criteria['code'] }}" placeholder="0" value="{{ $customerValues['values'][$criteria['id']]['value'] }}">
                        @else
                            <input type="number" name="values[{{ $criteria['id'] }}]" class="form-control" id="{{ $criteria['code'] }}" placeholder="0">
                        @endif
                        </div>
                    </div>
                    @endforeach
                    <div id="message"></div>
                </div>
                <div class="card-footer">
                    <button type="button" id="save-customer-value" class="btn btn-info">Simpan</button>
                    <a href="{{ url('/customer-value') }}" class="btn btn-default">Batal</a>
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
    $('#save-customer-value').on('click', function(e){
        var data = $('#customer-value-form').serialize();
        $.ajax({
            url: $('#customer-value-form').attr('action'),
            type: $('#customer-value-form').attr('method'),
            data: data,
            success: function(response) {
                $('#message').html('');
                location.href = "{{ url('/customer-value') }}";
            },
            error: function (request, error) {
                if (request.status == 400) {
                    $('#message').html('<div class="alert alert-danger" role="alert">Simpan Data Gagal! ' + request.responseJSON.message + '</div>')
                } else {
                    $('#message').html('<div class="alert alert-danger" role="alert">Simpan Data Gagal! Silahkan periksa kembali data yang anda inputkan</div>')
                }
            }
        });
        e.preventDefault();
    });
</script>
@stop