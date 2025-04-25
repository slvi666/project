@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-3">
          <div class="col-md-4 text-md-right">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('formulir.index') }}"><i class="fas fa-list"></i> Daftar Formulir</a></li>
              <li class="breadcrumb-item active">Detail Formulir</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="card shadow-lg rounded-lg border-0">
              <div class="card-header bg-gradient-primary text-white">
                <h3 class="card-title"><i class="fas fa-user-check"></i> Informasi Pendaftaran</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <!-- Kolom Kiri -->
                  <div class="col-md-6">
                    <ul class="list-group">
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

                  <!-- Kolom Kanan -->
                  <div class="col-md-6">
                    <ul class="list-group">
                      <li class="list-group-item"><strong>Nama Orangtua:</strong> {{ $formulir->nama_orangtua }}</li>
                      <li class="list-group-item"><strong>Nama Bapak:</strong> {{ $formulir->nama_bapak }}</li>
                      <li class="list-group-item"><strong>Pekerjaan Orangtua:</strong> {{ $formulir->pekerjaan_orangtua }}</li>
                      <li class="list-group-item"><strong>Penghasilan Orangtua:</strong> Rp {{ number_format($formulir->penghasilan_orangtua, 0, ',', '.') }}</li>
                      <li class="list-group-item"><strong>Jarak Rumah ke Sekolah:</strong> {{ $formulir->jarak_rumah_sekolah }} km</li>
                      <li class="list-group-item"><strong>Kendaraan:</strong> {{ $formulir->kendaraan }}</li>
                      <li class="list-group-item"><strong>Asal Sekolah:</strong> {{ $formulir->asal_sekolah }}</li>
                      <li class="list-group-item"><strong>Tahun Lulus:</strong> {{ $formulir->tahun_lulus }}</li>
                      <li class="list-group-item"><strong>Nilai US:</strong> {{ $formulir->nilai_us ?? '-' }}</li>
                      <li class="list-group-item status-item">
                        <strong>Status:</strong> 
                        <span class="badge badge-{{ strtolower($formulir->status) }}">
                          {{ $formulir->status }}
                        </span>
                      </li>
                    </ul>
                  </div>
                </div>

                <!-- Foto Pendaftar -->
                <div class="text-center mt-4">
                  <h5>Foto Pendaftar</h5>
                  <img src="{{ asset('storage/' . $formulir->foto) }}" 
                    class="img-fluid rounded shadow-lg foto-hover" 
                    style="max-width: 250px; transition: 0.3s; cursor: pointer;" 
                    data-toggle="modal" data-target="#fotoModal"
                    alt="Foto">
                </div>

                <!-- Berkas Sertifikat -->
                <div class="mt-4 text-center">
                  <h5>Berkas Sertifikat</h5>
                  @if ($formulir->berkas_sertifikat)
                    <a href="{{ asset('storage/' . $formulir->berkas_sertifikat) }}" class="btn btn-success" target="_blank">
                      <i class="fas fa-download"></i> Lihat Sertifikat
                    </a>
                  @else
                    <span class="text-muted">Tidak ada berkas sertifikat</span>
                  @endif
                </div>

              </div>

              <div class="card-footer text-right">
                <a href="{{ route('formulir.index') }}" class="btn btn-secondary">
                  <i class="fas fa-arrow-left"></i> Kembali
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
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
          <img src="{{ asset('storage/' . $formulir->foto) }}" class="img-fluid rounded shadow-lg" alt="Foto">
        </div>
      </div>
    </div>
  </div>

  <!-- Custom CSS -->
  <style>
    .foto-hover:hover {
      transform: scale(1.1);
      transition: 0.3s;
    }

    .status-item .badge {
      font-weight: bold;
      text-transform: uppercase;
    }

    .badge-pending {
      background-color: #007bff;
      color: white;
    }

    .badge-ditolak {
      background-color: #dc3545;
      color: white;
    }

    .badge-lulus {
      background-color: #28a745;
      color: white;
    }
  </style>
@endsection
