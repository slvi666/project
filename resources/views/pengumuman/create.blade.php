@extends('adminlte.layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah Pengumuman</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
            <li class="breadcrumb-item active">Tambah</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Form Tambah Pengumuman</h3>
            </div>
            <div class="card-body">
              <form action="{{ route('pengumuman.store') }}" method="POST">
                @csrf

                <div class="form-group">
                  <label for="judul">Judul</label>
                  <input type="text" name="judul_pengumuman" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="isi">Isi Pengumuman</label>
                  <textarea name="isi_pengumuman" class="form-control" rows="5" required></textarea>
                </div>

                <div class="form-group">
                  <label for="deskripsi">Deskripsi (Opsional)</label>
                  <textarea name="deskripsi_pengumuman" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                  <label for="status">Status</label>
                  <select name="status" class="form-control" required>
                    <option value="aktif">Aktif</option>
                    <option value="non aktif">Non Aktif</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="tanggal_mulai">Tanggal Mulai</label>
                  <input type="date" name="tanggal_mulai" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="tanggal_berakhir">Tanggal Berakhir</label>
                  <input type="date" name="tanggal_berakhir" class="form-control" required>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-success">Simpan</button>
                  <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
