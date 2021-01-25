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
            <h3>Laporan Penentuan Peringkat Pelanggan Terbaik</h3>
            <h3>PT.EDI Indonesia Periode 2020</h3>
            <h3>Dengan Menggunakan Metode Wighted Product(WP)</h3>
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