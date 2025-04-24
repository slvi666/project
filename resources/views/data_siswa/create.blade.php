@extends('adminlte.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Siswa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('data_siswa.index') }}">Daftar Siswa</a></li>
              <li class="breadcrumb-item active">Tambah Siswa</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Form Tambah Siswa</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{ route('data_siswa.store') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="user_id">Nama Siswa</label>
                <select name="user_id" class="form-control" required>
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="nis">NIS</label>
                <input type="text" name="nis" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" name="kelas" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control">
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="{{ route('data_siswa.index') }}" class="btn btn-secondary">Batal</a>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
