<!-- resources/views/data_guru/edit.blade.php -->
@extends('adminlte.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Data Guru</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Edit Data Guru</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Formulir Edit Data Guru</h3>
              </div>
              <div class="card-body">
                <form action="{{ route('data_guru.update', $guru->id) }}" method="POST">
                  @csrf
                  @method('PUT')

                  <div class="mb-3">
                    <label for="user_id" class="form-label">Nama Guru</label>
                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                      <option value="">Pilih Guru</option>
                      @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $guru->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                      @endforeach
                    </select>
                    @error('user_id')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $guru->nip) }}">
                    @error('nip')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="no_telpon" class="form-label">No Telepon</label>
                    <input type="text" name="no_telpon" id="no_telpon" class="form-control @error('no_telpon') is-invalid @enderror" value="{{ old('no_telpon', $guru->no_telpon) }}">
                    @error('no_telpon')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $guru->alamat) }}</textarea>
                    @error('alamat')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $guru->tanggal_lahir) }}">
                    @error('tanggal_lahir')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <a href="{{ route('data_guru.index') }}" class="btn btn-secondary">Batal</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
