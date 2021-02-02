<!DOCTYPE html>
<html>
    <head>
        <style>
        table, td, th {
        border: 1px solid black;
        }

        table {
        width: 100%;
        border-collapse: collapse;
        }
        </style>
    </head>
    <body>

        <center>
            <img src="{{ public_path() }}/{{ config('adminlte.logo_img') }}" height="50">
            <h3>LAPORAN PERINGKAT PENENTUAN PELANGGAN TERBAIK</h3>
            <h3>PT EDI INDONESIA</h3>
        </center>
        <table class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Nilai Hasil</th>
                    <th>Peringkat</th>
                </tr>
            </thead>
            <tbody>
            @php
            $i = 0;
            @endphp
            @foreach ($data as $data)
                <tr>
                    <td>{{ $data['id'] }}</td>
                    <td>{{ $data['name'] }}</td>
                    <td><center>{{ $data['value'] }}</center></td>
                    <td><center>{{ $i+1 }}</center></td>
                </tr>
                @php
                $i++;
                @endphp
                @if ($i == 5)
                    @break
                @endif
            @endforeach
            </tbody>
        </table>
    </body>
</html>