@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Buku</h1>
          </div>
          <div class="col-sm-6">
            <!-- breadcrumb atau lainnya dapat ditambahkan jika perlu -->
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="card shadow-sm border-0 rounded-lg">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Edit Buku</h5>
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

            <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <!-- Cover Buku -->
              <div class="mb-3">
                <label for="cover_buku" class="form-label">Cover Buku</label><br>
                <img src="{{ asset('storage/' . $buku->cover_buku) }}" width="150" class="mb-2 rounded">
                <input type="file" class="form-control rounded-pill px-3 py-2" name="cover_buku">
              </div>

              <!-- Judul Buku -->
              <div class="mb-3">
                <label for="judul" class="form-label">Judul Buku</label>
                <input type="text" class="form-control rounded-pill px-3 py-2" name="judul" value="{{ $buku->judul }}" required>
              </div>

              <!-- Penulis -->
              <div class="mb-3">
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" class="form-control rounded-pill px-3 py-2" name="penulis" value="{{ $buku->penulis }}" required>
              </div>

              <!-- Deskripsi -->
              <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control rounded-pill px-3 py-2" name="deskripsi" rows="3" required>{{ $buku->deskripsi }}</textarea>
              </div>

              <!-- Kategori -->
              <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-control rounded-pill px-3 py-2" name="kategori" required>
                  @foreach(\App\Models\Buku::getKategoriList() as $kategori)
                    <option value="{{ $kategori }}" {{ $buku->kategori == $kategori ? 'selected' : '' }}>
                      {{ ucfirst($kategori) }}
                    </option>
                  @endforeach
                </select>
              </div>

              <!-- File Buku (PDF) -->
              <div class="mb-3">
                <label for="file_buku" class="form-label">File Buku (PDF)</label><br>
                <a href="{{ asset('storage/' . $buku->file_buku) }}" target="_blank" class="text-primary">Lihat File</a>
                <input type="file" class="form-control rounded-pill px-3 py-2 mt-2" name="file_buku">
              </div>

              <div class="d-flex justify-content-start gap-2">
                <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                  <i class="fas fa-save me-1"></i> Update
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
