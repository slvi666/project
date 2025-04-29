@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary"><i class="fas fa-eye"></i> Detail Formulir Pendaftaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('formulir.index') }}">Daftar Formulir</a></li>
            <li class="breadcrumb-item active">Detail Formulir</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-lg border-0 rounded-lg bg-white">
        <div class="card-body p-5">
          <div class="row">
            <!-- Data Siswa -->
            <div class="col-md-6 mb-4">
              <div class="card shadow-sm border-0 rounded-lg mb-4">
                <div class="card-header bg-primary text-white rounded-top">
                  <h5><i class="fas fa-user-graduate"></i> Data Siswa</h5>
                </div>
                <div class="card-body">
                  <ul class="list-group list-group-flush">
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
              <div class="card shadow-sm border-0 rounded-lg mb-4">
                <div class="card-header bg-info text-white rounded-top">
                  <h5><i class="fas fa-users"></i> Data Orang Tua</h5>
                </div>
                <div class="card-body">
                  <ul class="list-group list-group-flush">
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
                            'pending' => 'primary',  // biru
                            'lulus' => 'success',    // hijau
                            'ditolak' => 'danger',   // merah
                        ];
                        $badgeColor = $statusColors[strtolower($formulir->status)] ?? 'secondary'; // fallback abu2
                    @endphp
                    
                    <strong>Status:</strong> 
                    <span class="badge badge-{{ $badgeColor }}">
                      {{ strtoupper($formulir->status) }}
                    </span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Foto Pendaftar -->
            <div class="col-md-6 mb-4 text-center">
              <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-primary text-white rounded-top">
                  <h5><i class="fas fa-image"></i> Foto Pendaftar</h5>
                </div>
                <div class="card-body">
                  <img src="{{ asset('storage/' . $formulir->foto) }}" 
                    class="img-fluid rounded shadow-lg foto-hover" 
                    style="max-width: 250px; transition: 0.3s; cursor: pointer;" 
                    data-toggle="modal" data-target="#fotoModal"
                    alt="Foto Pendaftar">
                </div>
              </div>
            </div>

            <!-- Berkas Sertifikat -->
            <div class="col-md-6 mb-4 text-center">
              <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-info text-white rounded-top">
                  <h5><i class="fas fa-file-download"></i> Berkas Sertifikat</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                  @if ($formulir->berkas_sertifikat)
                    <a href="{{ asset('storage/' . $formulir->berkas_sertifikat) }}" class="btn btn-success btn-lg rounded-pill" target="_blank">
                      <i class="fas fa-download"></i> Lihat Sertifikat
                    </a>
                  @else
                    <span class="text-muted">Tidak ada berkas sertifikat</span>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer bg-white text-right mt-4">
            <a href="{{ route('formulir.index') }}" class="btn btn-danger btn-lg rounded-pill">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
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
        <img src="{{ asset('storage/' . $formulir->foto) }}" class="img-fluid rounded shadow-lg" alt="Foto Pendaftar">
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
  .foto-hover:hover {
    transform: scale(1.1);
    transition: 0.3s;
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
  .card-header {
    border-radius: 10px 10px 0 0;
  }
  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
  }
</style>
@endpush

@endsection
