<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendaftar</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 10pt; }
        th, td { border: 1px solid black; padding: 5px; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Data Pendaftar</h2>
    <p>Tanggal Cetak: {{ date('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Gelombang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $index => $reg)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $reg->registration_code }}</td>
                <td>{{ $reg->personalDetail->full_name ?? $reg->user->name }}</td>
                <td>{{ $reg->major->name ?? '-' }}</td>
                <td>{{ $reg->batch->batch_name ?? '-' }}</td>
                <td>{{ ucfirst($reg->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
