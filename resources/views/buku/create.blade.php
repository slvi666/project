@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Buku</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('buku.index') }}">Daftar Buku</a></li>
              <li class="breadcrumb-item active">Tambah</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="card shadow-sm border-0 rounded-lg">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Tambah Buku</h5>
          </div>
          <div class="card-body">
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="cover_buku" class="form-label">Cover Buku</label>
                <input type="file" class="form-control rounded-pill px-3 py-2" name="cover_buku" required>
              </div>

              <div class="mb-3">
                <label for="judul" class="form-label">Judul Buku</label>
                <input type="text" class="form-control rounded-pill px-3 py-2" name="judul" placeholder="Masukkan judul buku" required>
              </div>

              <div class="mb-3">
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" class="form-control rounded-pill px-3 py-2" name="penulis" placeholder="Masukkan nama penulis" required>
              </div>

              <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control rounded-pill px-3 py-2" name="deskripsi" rows="3" placeholder="Masukkan deskripsi buku" required></textarea>
              </div>

              <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-control rounded-pill px-3 py-2" name="kategori" required>
                  <option value="" disabled selected>Pilih kategori</option>
                  @foreach(\App\Models\Buku::getKategoriList() as $kategori)
                    <option value="{{ $kategori }}">{{ ucfirst($kategori) }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="file_buku" class="form-label">File Buku (PDF)</label>
                <input type="file" class="form-control rounded-pill px-3 py-2" name="file_buku" required>
              </div>

              <div class="d-flex justify-content-start gap-2">
                <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                  <i class="fas fa-save me-1"></i> Simpan
                </button>
                <a href="{{ route('buku.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                  <i class="fas fa-arrow-left me-1"></i> Batal
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
