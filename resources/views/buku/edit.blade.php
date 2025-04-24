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
                <h3 class="card-title">Edit Buku</h3>
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

                  <div class="mb-3">
                    <label>Cover Buku</label><br>
                    <img src="{{ asset('storage/' . $buku->cover_buku) }}" width="150" class="mb-2">
                    <input type="file" class="form-control" name="cover_buku">
                  </div>
                  <div class="mb-3">
                    <label>Judul Buku</label>
                    <input type="text" class="form-control" name="judul" value="{{ $buku->judul }}" required>
                  </div>
                  <div class="mb-3">
                    <label>Penulis</label>
                    <input type="text" class="form-control" name="penulis" value="{{ $buku->penulis }}" required>
                  </div>
                  <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="3" required>{{ $buku->deskripsi }}</textarea>
                  </div>
                  <div class="mb-3">
                    <label>Kategori</label>
                    <select class="form-control" name="kategori" required>
                      @foreach(\App\Models\Buku::getKategoriList() as $kategori)
                        <option value="{{ $kategori }}" {{ $buku->kategori == $kategori ? 'selected' : '' }}>
                          {{ ucfirst($kategori) }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3">
                    <label>File Buku (PDF)</label><br>
                    <a href="{{ asset('storage/' . $buku->file_buku) }}" target="_blank">Lihat File</a>
                    <input type="file" class="form-control mt-2" name="file_buku">
                  </div>
                  <button type="submit" class="btn btn-success">Update</button>
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
