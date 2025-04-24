@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah Data Guru</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Daftar Guru</a></li>
            <li class="breadcrumb-item active">Tambah Data Guru</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">

          @if ($errors->any())
            <div class="alert alert-danger">
              <strong>Oops!</strong> Ada kesalahan dalam input.<br><br>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <label for="user_id">Nama Guru</label>
              <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                @foreach ($users as $user)
                  <option value="{{ $user->id }}" data-name="{{ $user->name }}">
                    {{ $user->name }} ({{ $user->email }})
                  </option>
                @endforeach
              </select>
            </div>
            

            <input type="hidden" name="nama_guru" id="nama_guru">

            <div class="form-group">
              <label for="nip">NIP</label>
              <input type="text" name="nip" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea name="alamat" class="form-control" rows="3" required></textarea>
            </div>

            <div class="form-group">
              <label for="jenis_kelamin">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>

            <div class="form-group">
              <label for="telepon">Telepon</label>
              <input type="text" name="telepon" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="tanggal_bergabung">Tanggal Bergabung</label>
              <input type="date" name="tanggal_bergabung" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="foto">Foto (opsional)</label>
              <input type="file" name="foto" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            <a href="{{ route('guru.index') }}" class="btn btn-secondary mt-3">Kembali</a>
          </form>

        </div>
      </div>
    </div>
  </section>
</div>

<script>
  document.getElementById('user_id').addEventListener('change', function () {
    let selectedOption = this.options[this.selectedIndex];
    let userName = selectedOption.getAttribute('data-name');
    document.getElementById('nama_guru').value = userName;
  });
</script>
@endsection
@section('scripts')