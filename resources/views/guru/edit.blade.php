@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Edit Data Guru</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Daftar Guru</a></li>
            <li class="breadcrumb-item active">Edit Data Guru</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">Form Edit Guru</h5>
            </div>
            <div class="card-body">

              @if ($errors->any())
                <script>
                  Swal.fire({
                    title: 'Kesalahan!',
                    html: `<ul>{!! implode('', $errors->all('<li>:message</li>')) !!}</ul>`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                  });
                </script>
              @endif

              <form action="{{ route('guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                  <label class="form-label">Pengguna (Guru)</label>
                  <input type="hidden" name="user_id" value="{{ $guru->user_id }}">
                  <input type="text" class="form-control rounded-pill px-3 py-2" value="{{ $guru->user->name }} ({{ $guru->user->email }})" readonly>
                </div>
                
                <div class="mb-3">
                  <label for="nip" class="form-label">NIP</label>
                  <input type="text" name="nip" class="form-control rounded-pill px-3 py-2" value="{{ $guru->nip }}" required>
                </div>

                <div class="mb-3">
                  <label for="nama_guru" class="form-label">Nama Guru</label>
                  <input type="text" name="nama_guru" class="form-control rounded-pill px-3 py-2" value="{{ $guru->nama_guru }}" required>
                </div>

                <div class="mb-3">
                  <label for="alamat" class="form-label">Alamat</label>
                  <input type="text" name="alamat" class="form-control rounded-pill px-3 py-2" value="{{ $guru->alamat }}" required>
                </div>

                <div class="mb-3">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select name="jenis_kelamin" class="form-control rounded-pill px-3 py-2" required>
                    <option value="Laki-laki" {{ $guru->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $guru->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="telepon" class="form-label">Telepon</label>
                  <input type="text" name="telepon" class="form-control rounded-pill px-3 py-2" value="{{ $guru->telepon }}" required>
                </div>

                <div class="mb-3">
                  <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                  <input type="date" name="tanggal_lahir" class="form-control rounded-pill px-3 py-2" value="{{ $guru->tanggal_lahir }}" required>
                </div>

                <div class="mb-3">
                  <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                  <input type="date" name="tanggal_bergabung" class="form-control rounded-pill px-3 py-2" value="{{ $guru->tanggal_bergabung }}" required>
                </div>

                <div class="mb-4">
                  <label for="foto" class="form-label">Foto</label>
                  <input type="file" name="foto" class="form-control rounded-pill px-3 py-2">
                  @if ($guru->foto)
                    <img src="{{ asset('storage/'.$guru->foto) }}" alt="Foto Guru" width="100" class="mt-2">
                  @endif
                </div>

                <div class="d-flex justify-content-start gap-2">
                  <a href="{{ route('guru.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                  </a>
                  <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                    <i class="fas fa-save me-1"></i> Simpan
                  </button>
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
