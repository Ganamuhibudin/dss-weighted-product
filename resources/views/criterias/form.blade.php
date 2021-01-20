@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Data Kriteria</h3>
            </div>
            @if(isset($criteria['id']))
            <form id="criteria-form" method="put" action="{{ url('/criteria') }}/{{ $criteria['id'] }}" class="form-horizontal">
            @else
            <form id="criteria-form" method="post" action="{{ url('/criteria') }}" class="form-horizontal">
            @endif
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="code" class="col-sm-2 col-form-label">Kode</label>
                        <div class="col-sm-10">
                            <input type="text" name="code" class="form-control" id="code" value="{{ $criteria['code'] ?? '' }}" placeholder="Kode">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama Kriteria</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="name" value="{{ $criteria['name'] ?? '' }}" placeholder="Nama Pelanggan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Atribut</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="atribut">
                            @if (isset($criteria))
                                <option value="keuntungan" {{ $criteria['atribut'] == "keuntungan" ? "selected=''" : "" }}>Keuntungan</option>
                                <option value="biaya" {{ $criteria['atribut'] == "biaya" ? "selected=''" : "" }}>Biaya</option>
                            @else
                                <option value="keuntungan">Keuntungan</option>
                                <option value="biaya">Biaya</option>
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="weight" class="col-sm-2 col-form-label">Bobot</label>
                        <div class="col-sm-10">
                            <input type="number" name="weight" class="form-control" id="phone" value="{{ $criteria['weight'] ?? '' }}" placeholder="0">
                        </div>
                    </div>
                    <div id="message"></div>
                </div>
                <div class="card-footer">
                    <button type="button" id="save-criteria" class="btn btn-info">Simpan</button>
                    <a href="{{ url('/criteria') }}" class="btn btn-default">Batal</a>
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
    $('#save-criteria').on('click', function(e){
        var data = $('#criteria-form').serialize();
        $.ajax({
            url: $('#criteria-form').attr('action'),
            type: $('#criteria-form').attr('method'),
            data: data,
            success: function(response) {
                $('#message').html('');
                location.href = "{{ url('/criteria') }}";
            },
            error: function (request, error) {
                $('#message').html('<div class="alert alert-danger" role="alert">Simpan Data Gagal! Silahkan periksa kembali data yang anda inputkan</div>')
            }
        });
        e.preventDefault();
    });
</script>
@stop