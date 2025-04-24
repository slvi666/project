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
                <h3 class="card-title">Tambah Buku</h3>
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
                    <label>Cover Buku</label>
                    <input type="file" class="form-control" name="cover_buku" required>
                  </div>
                  <div class="mb-3">
                    <label>Judul Buku</label>
                    <input type="text" class="form-control" name="judul" placeholder="Masukkan judul buku" required>
                  </div>
                  <div class="mb-3">
                    <label>Penulis</label>
                    <input type="text" class="form-control" name="penulis" placeholder="Masukkan nama penulis" required>
                  </div>
                  <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="3" placeholder="Masukkan deskripsi buku" required></textarea>
                  </div>
                  <div class="mb-3">
                    <label>Kategori</label>
                    <select class="form-control" name="kategori" required>
                      <option value="" disabled selected>Pilih kategori</option>
                      @foreach(\App\Models\Buku::getKategoriList() as $kategori)
                        <option value="{{ $kategori }}">{{ ucfirst($kategori) }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3">
                    <label>File Buku (PDF)</label>
                    <input type="file" class="form-control" name="file_buku" required>
                  </div>
                  <button type="submit" class="btn btn-success">Simpan</button>
                  <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
