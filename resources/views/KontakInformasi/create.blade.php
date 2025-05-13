@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Tambah Kontak Informasi</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('kontak-informasi.index') }}">Kontak Informasi</a></li>
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
            title: 'Oops!',
            html: `<ul>{!! implode('', $errors->all('<li>:message</li>')) !!}</ul>`,
            icon: 'error',
            confirmButtonText: 'Tutup'
          });
        </script>
      @endif

      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Form Tambah Kontak</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('kontak-informasi.store') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label class="form-label">Nama Identitas</label>
              <input type="text" name="nama_identitas" value="{{ old('nama_identitas') }}" class="form-control rounded-pill px-3 py-2" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Email (Opsional)</label>
              <input type="email" name="email" value="{{ old('email') }}" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="mb-3">
              <label class="form-label">No Telepon</label>
              <input type="text" name="no_telpon" value="{{ old('no_telpon') }}" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="mb-3">
              <label class="form-label">No WhatsApp</label>
              <input type="text" name="no_wa" value="{{ old('no_wa') }}" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="mb-3">
              <label class="form-label">Instagram</label>
              <input type="text" name="instagram" value="{{ old('instagram') }}" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="mb-3">
              <label class="form-label">Facebook</label>
              <input type="text" name="fb" value="{{ old('fb') }}" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="mb-4">
              <label class="form-label">Alamat</label>
              <textarea name="alamat" rows="3" class="form-control rounded-4 px-3 py-2">{{ old('alamat') }}</textarea>
            </div>

            <div class="d-flex justify-content-start gap-2">
              <a href="{{ route('kontak-informasi.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
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
