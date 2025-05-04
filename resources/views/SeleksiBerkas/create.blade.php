@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary"><i class="fas fa-file-upload"></i>Seleksi Berkas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('seleksi-berkas.index') }}">Daftar Seleksi Berkas</a></li>
            <li class="breadcrumb-item active">Tambah Seleksi Berkas</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white rounded-top">
          <h3 class="card-title"><i class="fas fa-plus-circle"></i> Formulir Seleksi Berkas</h3>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('seleksi-berkas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <label class="font-weight-semibold">User</label>
              <input type="text" class="form-control rounded-pill" value="{{ $user->name }}" disabled>
              <input type="hidden" name="user_id" value="{{ $user->id }}">
            </div>

            <div class="form-group">
              <label class="font-weight-semibold">Formulir Pendaftaran ID</label>
              <input type="text" class="form-control rounded-pill" value="{{ $formulir->id }}" disabled>
              <input type="hidden" name="formulir_pendaftaran_id" value="{{ $formulir->id }}">
            </div>

            <div class="form-group">
              <label for="poto_ktp_orang_tua" class="font-weight-semibold">Foto KTP Orang Tua <small class="text-muted">(format: jpg/png, maksimal 2MB)</small></label>
              <input type="file" name="poto_ktp_orang_tua" class="form-control rounded-pill @error('poto_ktp_orang_tua') is-invalid @enderror"required>
              @error('poto_ktp_orang_tua')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="kartu_keluarga" class="font-weight-semibold">Kartu Keluarga</label>
              <input type="file" name="kartu_keluarga" class="form-control rounded-pill @error('kartu_keluarga') is-invalid @enderror"required>
              @error('kartu_keluarga')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="akte_kelahiran" class="font-weight-semibold">Akte Kelahiran</label>
              <input type="file" name="akte_kelahiran" class="form-control rounded-pill @error('akte_kelahiran') is-invalid @enderror"required>
              @error('akte_kelahiran')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="surat_kelulusan" class="font-weight-semibold">Surat Kelulusan</label>
              <input type="file" name="surat_kelulusan" class="form-control rounded-pill @error('surat_kelulusan') is-invalid @enderror">
              @error('surat_kelulusan')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="raport" class="font-weight-semibold">Raport</label>
              <input type="file" name="raport" class="form-control rounded-pill @error('raport') is-invalid @enderror">
              @error('raport')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="kis_kip" class="font-weight-semibold">KIS/KIP</label>
              <input type="file" name="kis_kip" class="form-control rounded-pill @error('kis_kip') is-invalid @enderror"required>
              @error('kis_kip')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="ijazah" class="font-weight-semibold">Ijazah</label>
              <input type="file" name="ijazah" class="form-control rounded-pill @error('ijazah') is-invalid @enderror">
              @error('ijazah')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group mt-4">
              <button type="submit" class="btn btn-success btn-lg rounded-pill"><i class="fas fa-save"></i> Simpan</button>
              <a href="{{ route('seleksi-berkas.index') }}" class="btn btn-danger btn-lg rounded-pill"><i class="fas fa-times"></i> Batal</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

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
  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
  }
  .btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
  }
</style>
@endpush
