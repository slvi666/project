@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Tambah Data Guru</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Daftar Guru</a></li>
            <li class="breadcrumb-item active">Tambah Data Guru</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">Form Tambah Guru</h5>
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

              <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                  <label for="user_id" class="form-label">Nama Guru</label>
                  <select name="user_id" id="user_id" class="form-control rounded-pill px-3 py-2" required>
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                      <option value="{{ $user->id }}" data-name="{{ $user->name }}">
                        {{ $user->name }} ({{ $user->email }})
                      </option>
                    @endforeach
                  </select>
                  <input type="hidden" name="nama_guru" id="nama_guru">
                </div>

                <div class="mb-3">
                  <label for="nip" class="form-label">NIP</label>
                  <input type="text" name="nip" class="form-control rounded-pill px-3 py-2" required>
                </div>

                <div class="mb-3">
                  <label for="alamat" class="form-label">Alamat</label>
                  <textarea name="alamat" class="form-control rounded-4 px-3 py-2" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select name="jenis_kelamin" class="form-control rounded-pill px-3 py-2" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="telepon" class="form-label">Telepon</label>
                  <input type="text" name="telepon" class="form-control rounded-pill px-3 py-2" required>
                </div>

                <div class="mb-3">
                  <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                  <input type="date" name="tanggal_lahir" class="form-control rounded-pill px-3 py-2" required>
                </div>

                <div class="mb-3">
                  <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                  <input type="date" name="tanggal_bergabung" class="form-control rounded-pill px-3 py-2" required>
                </div>

                <div class="mb-4">
                  <label for="foto" class="form-label">Foto (opsional)</label>
                  <input type="file" name="foto" class="form-control rounded-pill px-3 py-2">
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
<script>
  document.getElementById('user_id').addEventListener('change', function () {
    let selectedOption = this.options[this.selectedIndex];
    let userName = selectedOption.getAttribute('data-name');
    document.getElementById('nama_guru').value = userName;
  });
</script>
@endsection
