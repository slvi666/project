@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Dokumen Kegiatan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dok_kegiatan.index') }}">Dokumen Kegiatan</a></li>
              <li class="breadcrumb-item active">Tambah Dokumen</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Form Tambah Dokumen</h3>
              </div>
              <div class="card-body">
                <form action="{{ route('dok_kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-3">
                    <label>Nama Dokumen</label>
                    <input type="text" name="nama_dokumen" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                  </div>
                  <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" name="path_file" class="form-control" accept="image/*" required>
                  </div>
                  <button type="submit" class="btn btn-success">Simpan</button>
                  <a href="{{ route('dok_kegiatan.index') }}" class="btn btn-secondary">Batal</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @if(session('success'))
    <script>
      Swal.fire({
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = "{{ route('dok_kegiatan.index') }}"; 
      });
    </script>
  @endif
@endsection
