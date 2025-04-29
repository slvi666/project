@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary"><i class="fas fa-user-plus"></i> Tambah Formulir Pendaftaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('formulir.index') }}">Daftar Formulir</a></li>
            <li class="breadcrumb-item active">Tambah Formulir</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-lg border-0 rounded-lg bg-white">
        <div class="card-body p-5">
          @if ($errors->any())
            <script>
              Swal.fire({
                title: 'Kesalahan!',
                html: "{!! implode('', $errors->all('<li>:message</li>')) !!}",
                icon: 'error',
                confirmButtonText: 'OK'
              });
            </script>
          @endif

          <form action="{{ route('formulir.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <!-- Data Siswa -->
              <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-lg">
                  <div class="card-header bg-primary text-white rounded-top">
                    <h5><i class="fas fa-user-graduate"></i> Data Siswa</h5>
                  </div>
                  <div class="card-body">
                    @foreach ([ 
                      'nik' => 'NIK',
                      'tempat_lahir' => 'Tempat Lahir',
                      'tanggal_lahir' => 'Tanggal Lahir',
                      'agama' => 'Agama',
                      'no_hp' => 'No HP',
                      'alamat' => 'Alamat'
                    ] as $field => $label)
                      <div class="form-group">
                        <label for="{{ $field }}" class="font-weight-semibold text-dark">{{ $label }}</label>
                        @if ($field == 'alamat')
                          <textarea name="{{ $field }}" class="form-control rounded-pill" rows="2" required></textarea>
                        @elseif ($field == 'tanggal_lahir')
                          <input type="date" name="{{ $field }}" class="form-control rounded-pill" required>
                        @else
                          <input type="text" name="{{ $field }}" class="form-control rounded-pill" required>
                        @endif
                      </div>
                    @endforeach

                        @php
                        $currentUser = auth()->user(); // Mendapatkan pengguna yang sedang login
                    @endphp
                    
                    <div class="form-group">
                      <label for="user_id" class="font-weight-semibold text-dark">Nama</label>
                      <!-- Menampilkan Nama Pengguna yang sedang login dan tidak dapat diedit -->
                      <input type="text" name="user_id" value="{{ $currentUser->id }}" hidden>
                      <input type="text" class="form-control rounded-pill" value="{{ $currentUser->name }}" readonly>
                    </div>
                    
                    <div class="form-group">
                      <label for="user_email" class="font-weight-semibold text-dark">Email</label>
                      <!-- Menampilkan Email Pengguna yang sedang login dan tidak dapat diedit -->
                      <input type="email" class="form-control rounded-pill" value="{{ $currentUser->email }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="jenis_kelamin" class="font-weight-semibold text-dark">Jenis Kelamin</label>
                      <select name="jenis_kelamin" class="form-control rounded-pill" required>
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Data Orang Tua -->
              <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-lg">
                  <div class="card-header bg-info text-white rounded-top">
                    <h5><i class="fas fa-users"></i> Data Orang Tua</h5>
                  </div>
                  <div class="card-body">
                    @foreach ([ 
                      'nama_orangtua' => 'Nama Ibu Kandung',
                      'nama_bapak' => 'Nama Bapak Kandung',
                      'pekerjaan_orangtua' => 'Pekerjaan Orang Tua',
                      'penghasilan_orangtua' => 'Penghasilan Orang Tua',
                      'jarak_rumah_sekolah' => 'Jarak Rumah ke Sekolah (km)',
                      'kendaraan' => 'Kendaraan',
                      'asal_sekolah' => 'Asal Sekolah',
                      'tahun_lulus' => 'Tahun Lulus'
                    ] as $field => $label)
                      <div class="form-group">
                        <label for="{{ $field }}" class="font-weight-semibold text-dark">{{ $label }}</label>
                        <input type="{{ in_array($field, ['penghasilan_orangtua', 'jarak_rumah_sekolah', 'tahun_lulus']) ? 'number' : 'text' }}" name="{{ $field }}" class="form-control rounded-pill" required>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <!-- Data Tambahan -->
              <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-lg">
                  <div class="card-header bg-primary text-white rounded-top">
                    <h5><i class="fas fa-chart-line"></i> Data Tambahan</h5>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nilai_us" class="font-weight-semibold text-dark">Nilai US</label>
                      <input type="number" name="nilai_us" class="form-control rounded-pill" step="0.01" min="0" max="100">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Upload Dokumen -->
              <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-lg">
                  <div class="card-header bg-info text-white rounded-top">
                    <h5><i class="fas fa-file-upload"></i> Upload Dokumen</h5>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="foto" class="font-weight-semibold text-dark">Foto</label>
                      <input type="file" name="foto" class="form-control rounded-pill" accept="image/*" required>
                    </div>

                    <div class="form-group">
                      <label for="berkas_sertifikat" class="font-weight-semibold text-dark">Berkas Sertifikat</label>
                      <input type="file" name="berkas_sertifikat" class="form-control rounded-pill" accept=".pdf,.doc,.docx">
                      <small class="text-muted">Opsional (format: PDF, DOC, DOCX)</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer bg-white text-right mt-4">
              <button type="submit" class="btn btn-success btn-lg rounded-pill"><i class="fas fa-save"></i> Simpan</button>
              <a href="{{ route('formulir.index') }}" class="btn btn-danger btn-lg rounded-pill"><i class="fas fa-times"></i> Batal</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@push('styles')
<style>
  .form-control {
    border-radius: 15px;
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
  }
  .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
  }
  .card-header {
    border-radius: 10px 10px 0 0;
  }
  .card-body {
    padding: 30px;
  }
  .btn-primary:hover, .btn-outline-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
  }
</style>
@endpush

@endsection
