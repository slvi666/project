@extends('adminlte.layouts.app')

@section('content')
<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Pengumuman</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
            <li class="breadcrumb-item active">Edit</li>
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
              <h3 class="card-title">Form Edit Pengumuman</h3>
            </div>
            <div class="card-body">
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                  <label>Judul</label>
                  <input type="text" name="judul_pengumuman" value="{{ $pengumuman->judul_pengumuman }}" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Isi Pengumuman</label>
                  <textarea name="isi_pengumuman" class="form-control" rows="5" required>{{ $pengumuman->isi_pengumuman }}</textarea>
                </div>

                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea name="deskripsi_pengumuman" class="form-control" rows="3">{{ $pengumuman->deskripsi_pengumuman }}</textarea>
                </div>

                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control" required>
                    <option value="aktif" {{ $pengumuman->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="non aktif" {{ $pengumuman->status === 'non aktif' ? 'selected' : '' }}>Non Aktif</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Tanggal Mulai</label>
                  <input type="date" name="tanggal_mulai" value="{{ $pengumuman->tanggal_mulai }}" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Tanggal Berakhir</label>
                  <input type="date" name="tanggal_berakhir" value="{{ $pengumuman->tanggal_berakhir }}" class="form-control" required>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Update</button>
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
