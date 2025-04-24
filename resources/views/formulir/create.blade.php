@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Formulir Pendaftaran</h1>
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
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header bg-primary text-white">
                <h3 class="card-title">Form Pendaftaran</h3>
              </div>
              <div class="card-body">
                @if ($errors->any())
                  <script>
                    Swal.fire({
                      title: 'Kesalahan!',
                      html: "<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>",
                      icon: 'error',
                      confirmButtonText: 'OK'
                    });
                  </script>
                @endif

                <form action="{{ route('formulir.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <!-- Bagian Data Siswa -->
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Nama Lengkap</label>
                        <select name="user_id" class="form-control" required>
                          @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                          <option value="Laki-laki">Laki-laki</option>
                          <option value="Perempuan">Perempuan</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Agama</label>
                        <input type="text" name="agama" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" required></textarea>
                      </div>
                    </div>

                    <!-- Bagian Data Orang Tua -->
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Nama Ibu Kandung</label>
                        <input type="text" name="nama_orangtua" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Nama Bapak Kandung</label>
                        <input type="text" name="nama_bapak" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Pekerjaan Orang tua</label>
                        <input type="text" name="pekerjaan_orangtua" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Penghasilan Orangtua</label>
                        <input type="number" name="penghasilan_orangtua" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Jarak Rumah ke Sekolah (km)</label>
                        <input type="number" name="jarak_rumah_sekolah" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Kendaraan</label>
                        <input type="text" name="kendaraan" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Tahun Lulus</label>
                        <input type="number" name="tahun_lulus" class="form-control" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Nilai US</label>
                        <input type="number" name="nilai_us" class="form-control" step="0.01" min="0" max="100">
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control" accept="image/*" required>
                      </div>
                      <div class="form-group">
                        <label>Berkas Sertifikat</label>
                        <input type="file" name="berkas_sertifikat" class="form-control" accept=".pdf,.doc,.docx">
                        <small class="text-muted">Opsional (format: PDF, DOC, DOCX)</small>
                      </div>
                    </div>
                  </div>

                  <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('formulir.index') }}" class="btn btn-secondary">Batal</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
