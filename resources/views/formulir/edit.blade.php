@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Formulir Pendaftaran</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('formulir.index') }}">Daftar Formulir</a></li>
              <li class="breadcrumb-item active">Edit Formulir</li>
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
                <h3 class="card-title">Form Edit Pendaftaran</h3>
              </div>
              <div class="card-body">
               
                
                <form action="{{ route('formulir.update', $formulir->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik', $formulir->nik) }}" required>
                      </div>
                      <div class="form-group">
                        <label for="user_id">User</label>
                        <select name="user_id" class="form-control" required>
                          @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $formulir->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $formulir->tanggal_lahir) }}" required>
                      </div>
                      <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $formulir->tempat_lahir) }}" required>
                      </div>
                      <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                          <option value="Laki-laki" {{ $formulir->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                          <option value="Perempuan" {{ $formulir->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="agama">Agama</label>
                        <input type="text" name="agama" class="form-control" value="{{ old('agama', $formulir->agama) }}" required>
                      </div>
                      <div class="form-group">
                        <label for="no_hp">No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $formulir->no_hp) }}" required>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" class="form-control" required>{{ old('alamat', $formulir->alamat) }}</textarea>
                      </div>
                      <div class="form-group">
                        <label for="nama_orangtua">Nama Orang Tua</label>
                        <input type="text" name="nama_orangtua" class="form-control" value="{{ old('nama_orangtua', $formulir->nama_orangtua) }}" required>
                      </div>
                      <div class="form-group">
                        <label for="nama_bapak">Nama Bapak</label>
                        <input type="text" name="nama_bapak" class="form-control" value="{{ old('nama_bapak', $formulir->nama_bapak) }}" required>
                      </div>
                      <div class="form-group">
                        <label for="pekerjaan_orangtua">Pekerjaan Orangtua</label>
                        <input type="text" name="pekerjaan_orangtua" class="form-control" value="{{ old('pekerjaan_orangtua', $formulir->pekerjaan_orangtua) }}" required>
                      </div>
                      <div class="form-group">
                        <label for="penghasilan_orangtua">Penghasilan Orangtua</label>
                        <input type="number" name="penghasilan_orangtua" class="form-control" value="{{ old('penghasilan_orangtua', $formulir->penghasilan_orangtua) }}" required>
                      </div>
                      <div class="form-group">
                        <label for="jarak_rumah_sekolah">Jarak Rumah ke Sekolah (km)</label>
                        <input type="number" name="jarak_rumah_sekolah" class="form-control" value="{{ old('jarak_rumah_sekolah', $formulir->jarak_rumah_sekolah) }}" required>
                      </div>
                      <div class="form-group">
                        <label for="kendaraan">Kendaraan</label>
                        <input type="text" name="kendaraan" class="form-control" value="{{ old('kendaraan', $formulir->kendaraan) }}" required>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                      <option value="Pending" {{ $formulir->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                      <option value="Tidak Lulus" {{ $formulir->status == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                      <option value="Lulus" {{ $formulir->status == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" required>
                  </div>

                  <div class="form-group">
                    <label for="berkas_sertifikat">Berkas Sertifikat</label>
                    <input type="file" name="berkas_sertifikat" class="form-control" accept=".pdf,.doc,.docx">
                  </div>

                  <div class="form-group">
                    <label for="nilai_us">Nilai US</label>
                    <input type="number" name="nilai_us" class="form-control" step="0.01" value="{{ old('nilai_us', $formulir->nilai_us) }}">
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


@endsection
