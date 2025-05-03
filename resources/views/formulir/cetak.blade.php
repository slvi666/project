<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Detail Pendaftar</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    .card-header h5 {
      margin: 0;
      font-size: 1rem;
    }

    .list-group-item {
      font-size: 0.9rem;
      padding: 0.5rem 1rem;
    }

    .card-body img {
      max-height: 150px;
      object-fit: contain;
    }

    .foto-hover:hover {
      transform: scale(1.05);
    }

    .card-footer {
      text-align: right;
    }

    .badge {
      font-size: 0.85rem;
      padding: 0.4em 0.6em;
    }
  </style>
</head>
<body>

<div class="container-fluid py-4">
  <div class="card shadow border-0 rounded-lg bg-white">
    <div class="card-body p-4">
      <div class="row g-3">
        <!-- Data Siswa -->
        <div class="col-md-6 mb-4">
          <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-primary text-white rounded-top">
              <h5><i class="fas fa-user-graduate"></i> Data Siswa</h5>
            </div>
            <div class="card-body p-3">
              <ul class="list-group list-group-flush small">
                <li class="list-group-item"><strong>Nama Lengkap:</strong> {{ $formulir->user->name }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $formulir->user->email }}</li>
                <li class="list-group-item"><strong>NIK:</strong> {{ $formulir->nik }}</li>
                <li class="list-group-item"><strong>TTL:</strong> {{ $formulir->tempat_lahir }}, {{ $formulir->tanggal_lahir }}</li>
                <li class="list-group-item"><strong>Jenis Kelamin:</strong> {{ $formulir->jenis_kelamin }}</li>
                <li class="list-group-item"><strong>Agama:</strong> {{ $formulir->agama }}</li>
                <li class="list-group-item"><strong>No HP:</strong> {{ $formulir->no_hp }}</li>
                <li class="list-group-item"><strong>Alamat:</strong> {{ $formulir->alamat }}</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="col-md-6 mb-4">
          <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-info text-white rounded-top">
              <h5><i class="fas fa-users"></i> Data Orang Tua</h5>
            </div>
            <div class="card-body p-3">
              <ul class="list-group list-group-flush small">
                <li class="list-group-item"><strong>Nama Ibu Kandung:</strong> {{ $formulir->nama_orangtua }}</li>
                <li class="list-group-item"><strong>Nama Bapak Kandung:</strong> {{ $formulir->nama_bapak }}</li>
                <li class="list-group-item"><strong>Pekerjaan Orangtua:</strong> {{ $formulir->pekerjaan_orangtua }}</li>
                <li class="list-group-item"><strong>Penghasilan Orangtua:</strong> Rp {{ number_format($formulir->penghasilan_orangtua, 0, ',', '.') }}</li>
                <li class="list-group-item"><strong>Jarak Rumah ke Sekolah:</strong> {{ $formulir->jarak_rumah_sekolah }} km</li>
                <li class="list-group-item"><strong>Kendaraan:</strong> {{ $formulir->kendaraan }}</li>
                <li class="list-group-item"><strong>Asal Sekolah:</strong> {{ $formulir->asal_sekolah }}</li>
                <li class="list-group-item"><strong>Tahun Lulus:</strong> {{ $formulir->tahun_lulus }}</li>
                <li class="list-group-item"><strong>Nilai US:</strong> {{ $formulir->nilai_us ?? '-' }}</li>
                <li class="list-group-item">
                  @php
                    $statusColors = [
                        'pending' => 'primary',
                        'lulus' => 'success',
                        'ditolak' => 'danger',
                    ];
                    $badgeColor = $statusColors[strtolower($formulir->status)] ?? 'secondary';
                  @endphp
                  <strong>Status:</strong> 
                  <span class="badge badge-{{ $badgeColor }}">{{ strtoupper($formulir->status) }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-3">
        <!-- Foto -->
        <div class="col-md-6 mb-4 text-center">
          <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-primary text-white rounded-top">
              <h5><i class="fas fa-image"></i> Foto Pendaftar</h5>
            </div>
            <div class="card-body">
              <img src="{{ asset('storage/' . $formulir->foto) }}" class="img-fluid rounded shadow-lg foto-hover"
                style="max-width: 250px; transition: 0.3s; cursor: pointer;" data-toggle="modal"
                data-target="#fotoModal" alt="Foto Pendaftar">
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Modal Foto -->
<div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fotoModalLabel">Foto Pendaftar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img src="{{ asset('storage/' . $formulir->foto) }}" class="img-fluid rounded shadow-lg" alt="Foto Pendaftar">
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script>
  window.onload = function () {
    const element = document.body;

    const opt = {
      margin:       0.5,
      filename:     'Detail_Pendaftar.pdf',
      image:        { type: 'jpeg', quality: 0.98 },
      html2canvas:  { scale: 2 },
      jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save();
  };
</script>

</body>
</html>
