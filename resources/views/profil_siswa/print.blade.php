<!-- resources/views/profil_siswa/print.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .profile-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .profile-info table, .profile-info th, .profile-info td {
            border: 1px solid #ccc;
        }
        .profile-info th, .profile-info td {
            padding: 8px;
            text-align: left;
        }
        .profile-info img {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Detail Siswa</h1>
    </div>

    <div class="profile-info">
        <table>
            <tr>
                <th>Nama</th>
                <td>{{ $siswa->user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $siswa->user->email }}</td>
            </tr>
            <tr>
                <th>NISN</th>
                <td>{{ $siswa->nisn }}</td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>
