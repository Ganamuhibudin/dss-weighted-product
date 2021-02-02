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
            <h3>LAPORAN KESELURUHAN NILAI PELANGGAN</h3>
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
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $customer['name'] }}</td>
                    <td><center>{{ $nilaiVectorV[$i] }}</center></td>
                    <td><center>{{ array_search($nilaiVectorV[$i], $rank) + 1 }}</center></td>
                </tr>
                @php
                $i++;
                @endphp
            @endforeach
            </tbody>
        </table>
    </body>
</html>