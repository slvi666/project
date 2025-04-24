@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Mata Pelajaran</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Daftar Mata Pelajaran</a></li>
              <li class="breadcrumb-item active">Tambah</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Form Tambah Mata Pelajaran</h3>
              </div>
              <div class="card-body">
                <form action="{{ route('subjects.store') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label class="form-label">Nama Kelas</label>
                    <input type="text" name="class_name" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Nama Mata Pelajaran</label>
                    <input type="text" name="subject_name" class="form-control" required>
                  </div>
                  <button type="submit" class="btn btn-success">Simpan</button>
                  <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Batal</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection