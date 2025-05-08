<!DOCTYPE html>
<html>
<head>
    <title>Detail Guru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Detail Guru</h1>
    <table>
        <tr>
            <th>NIP</th>
            <td>{{ $guru->nip }}</td>
        </tr>
        <tr>
            <th>Nama Guru</th>
            <td>{{ $guru->nama_guru }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $guru->alamat }}</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>{{ $guru->jenis_kelamin }}</td>
        </tr>
        <tr>
            <th>Telepon</th>
            <td>{{ $guru->telepon }}</td>
        </tr>
        <tr>
            <th>Tanggal Lahir</th>
            <td>{{ $guru->tanggal_lahir }}</td>
        </tr>
        <tr>
            <th>Tanggal Bergabung</th>
            <td>{{ $guru->tanggal_bergabung }}</td>
        </tr>
    </table>
</body>
</html>
