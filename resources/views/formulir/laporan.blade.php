<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendaftaran & Seleksi Berkas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background: #007bff;
            color: white;
        }
        .btn-custom {
            border-radius: 50px;
            padding: 10px 20px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #007bff;
            font-weight: bold;
        }
        .nav-link:hover {
            text-decoration: none;
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center text-primary">Laporan Pendaftaran & Seleksi Berkas</h2>
        
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('home') }}" class="btn btn-secondary btn-custom">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button class="btn btn-success btn-custom" onclick="exportTableToExcel('laporan_pendaftaran.xlsx')">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
            <button class="btn btn-primary btn-custom" onclick="printTable()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
        
        <div class="table-responsive">
            <table id="laporanTable" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Asal Sekolah</th>
                        <th>Status</th>
                        <th>Seleksi Berkas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->nik }}</td>
                            <td>{{ $data->tempat_lahir }}, {{ $data->tanggal_lahir }}</td>
                            <td>{{ $data->asal_sekolah }}</td>
                            <td>
                                <span class="badge {{ $data->status == 'Diterima' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $data->status }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $data->seleksiBerkas ? 'bg-primary' : 'bg-warning' }}">
                                    {{ $data->seleksiBerkas ? 'Berkas Lengkap' : 'Belum Lengkap' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#laporanTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
            });
        });

        function exportTableToExcel(filename) {
            let table = document.getElementById("laporanTable");
            let wb = XLSX.utils.book_new();
            let ws = XLSX.utils.table_to_sheet(table);
            XLSX.utils.book_append_sheet(wb, ws, "Laporan");
            XLSX.writeFile(wb, filename);
        }

        function printTable() {
            let printContent = document.querySelector(".table-responsive").innerHTML;
            let originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            location.reload();
        }
    </script>
</body>
</html>