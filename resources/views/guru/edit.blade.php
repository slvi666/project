@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Data Guru</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Edit Guru</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Form Edit Guru</h3>
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
                
                <form action="{{ route('guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="user_id">Pengguna (Guru)</label>
                    <select name="user_id" class="form-control">
                      @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $guru->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" name="nip" class="form-control" value="{{ $guru->nip }}">
                  </div>
                  <div class="form-group">
                    <label for="nama_guru">Nama Guru</label>
                    <input type="text" name="nama_guru" class="form-control" value="{{ $guru->nama_guru }}">
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="{{ $guru->alamat }}">
                  </div>
                  <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control">
                      <option value="Laki-laki" {{ $guru->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                      <option value="Perempuan" {{ $guru->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="{{ $guru->telepon }}">
                  </div>
                  <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ $guru->tanggal_lahir }}">
                  </div>
                  <div class="form-group">
                    <label for="tanggal_bergabung">Tanggal Bergabung</label>
                    <input type="date" name="tanggal_bergabung" class="form-control" value="{{ $guru->tanggal_bergabung }}">
                  </div>
                  <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" class="form-control">
                    @if ($guru->foto)
                      <img src="{{ asset('storage/'.$guru->foto) }}" alt="Foto Guru" width="100" class="mt-2">
                    @endif
                  </div>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <a href="{{ route('guru.index') }}" class="btn btn-secondary">Batal</a>
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