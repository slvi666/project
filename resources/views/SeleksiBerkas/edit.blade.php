@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary"><i class="fas fa-edit"></i> Edit Seleksi Berkas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('seleksi-berkas.index') }}">Daftar Seleksi Berkas</a></li>
            <li class="breadcrumb-item active">Edit Seleksi Berkas</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-lg border-0 rounded-lg bg-white">
        <div class="card-body p-5">

          @if ($errors->any())
          <script>
            Swal.fire({
              title: 'Kesalahan!',
              html: "{!! implode('', $errors->all('<li>:message</li>')) !!}",
              icon: 'error',
              confirmButtonText: 'OK'
            });
          </script>
          @endif

          <form action="{{ route('seleksi-berkas.update', $seleksiBerkas->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
              <!-- Data Seleksi Berkas -->
              <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-lg">
                  <div class="card-header bg-primary text-white rounded-top">
                    <h5><i class="fas fa-file-alt"></i> Data Seleksi Berkas</h5>
                  </div>
                  <div class="card-body">
                    @foreach ([
                      'poto_ktp_orang_tua' => 'Foto KTP Orang Tua',
                      'kartu_keluarga' => 'Kartu Keluarga',
                      'akte_kelahiran' => 'Akte Kelahiran',
                      'surat_kelulusan' => 'Surat Kelulusan',
                      'raport' => 'Raport',
                      'kis_kip' => 'KIS/KIP',
                      'ijazah' => 'Ijazah'] as $name => $label)
                      <div class="form-group">
                        <label for="{{ $name }}" class="font-weight-semibold text-dark">{{ $label }}</label>
                        <input type="file" class="form-control rounded-pill @error($name) is-invalid @enderror" name="{{ $name }}">
                        @error($name)
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($seleksiBerkas->$name)
                          <!-- Beautified file link -->
                          <a href="{{ asset('storage/' . $seleksiBerkas->$name) }}" target="_blank" class="btn btn-sm btn-info rounded-pill mt-2">
                            <i class="fas fa-eye"></i> Lihat File
                          </a>
                        @endif
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>

              <!-- User Info -->
              <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-lg">
                  <div class="card-header bg-info text-white rounded-top">
                    <h5><i class="fas fa-user"></i> Informasi Pengguna</h5>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="user_id" class="font-weight-semibold text-dark">Nama Pengguna</label>
                      <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                      <input type="hidden" name="formulir_pendaftaran_id" value="{{ $seleksiBerkas->formulir_pendaftaran_id }}">
                      <input type="text" class="form-control rounded-pill" value="{{ auth()->user()->name }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="user_email" class="font-weight-semibold text-dark">Email</label>
                      <input type="email" name="user_email" class="form-control rounded-pill" value="{{ old('user_email', $seleksiBerkas->user->email) }}" readonly>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer bg-white text-right mt-4">
              <button type="submit" class="btn btn-success btn-lg rounded-pill"><i class="fas fa-save"></i> Simpan</button>
              <a href="{{ route('seleksi-berkas.index') }}" class="btn btn-danger btn-lg rounded-pill"><i class="fas fa-times"></i> Batal</a>
            </div>

          </form>

        </div>
      </div>
    </div>
  </section>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@push('styles')
<style>
  .form-control {
    border-radius: 15px;
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
  }
  .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
  }
  .card-header {
    border-radius: 10px 10px 0 0;
  }
  .card-body {
    padding: 30px;
  }
  .btn-primary:hover, .btn-outline-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
  }
  /* Style for file link */
  .btn-info {
    text-decoration: none;
    padding: 8px 15px;
    font-size: 14px;
  }
  .btn-info:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }
</style>
@endpush

@endsection
