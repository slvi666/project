@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Tambah Pengumuman</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
            <li class="breadcrumb-item active">Tambah</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
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

      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Form Tambah Pengumuman</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('pengumuman.store') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label for="judul" class="form-label">Judul</label>
              <input type="text" name="judul_pengumuman" class="form-control rounded-pill px-3 py-2" required>
            </div>

            <div class="mb-3">
              <label for="isi" class="form-label">Isi Pengumuman</label>
              <textarea name="isi_pengumuman" class="form-control rounded-4 px-3 py-2" rows="5" required></textarea>
            </div>

            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
              <textarea name="deskripsi_pengumuman" class="form-control rounded-4 px-3 py-2" rows="3"></textarea>
            </div>

            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select name="status" class="form-control rounded-pill px-3 py-2" required>
                <option value="aktif">Aktif</option>
                <option value="non aktif">Non Aktif</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
              <input type="date" name="tanggal_mulai" class="form-control rounded-pill px-3 py-2" required>
            </div>

            <div class="mb-4">
              <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
              <input type="date" name="tanggal_berakhir" class="form-control rounded-pill px-3 py-2" required>
            </div>

            <div class="d-flex justify-content-start gap-2">
              <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
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
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
