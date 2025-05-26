@extends('adminlte.layouts.app')

@section('content')
<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Optional Styling for Select2 -->
<style>
.select2-container .select2-selection--single {
  height: 38px !important;
  border-radius: 50px !important;
  padding: 6px 12px !important;
  border: 1px solid #ced4da !important;
  font-size: 14px;
  background-color: #fff !important;
  box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
}

.select2-selection__rendered {
  line-height: 24px !important;
}

.select2-selection__arrow {
  height: 36px !important;
  top: 1px !important;
  right: 10px;
}
</style>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Tambah Materi Pembelajaran</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('materi.index') }}">Daftar Materi</a></li>
            <li class="breadcrumb-item active">Tambah Materi</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if ($errors->any())
        <script>
          Swal.fire({
            title: 'Kesalahan!',
            html: `<ul>{!! implode('', $errors->all('<li>:message</li>')) !!}</ul>`,
            icon: 'error',
            confirmButtonText: 'OK'
          });
        </script>
      @endif

      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Form Tambah Materi</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="guru_id" value="{{ auth()->user()->id }}">

            <div class="mb-3">
              <label class="form-label">Guru</label>
              <input type="text" class="form-control rounded-pill px-3 py-2" value="{{ auth()->user()->name }}" readonly>
            </div>

            <div class="mb-3">
              <label for="subject_id" class="form-label">Mata Pelajaran</label>
              <select name="subject_id" class="form-control select2 rounded-pill px-3 py-2" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach($subject as $s)
                  <option value="{{ $s->id }}">{{ $s->subject_name }} - {{ $s->class_name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="file" class="form-label">File PDF</label>
              <input type="file" name="file" class="form-control rounded-pill px-3 py-2" required accept="application/pdf">
            </div>

            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <textarea name="deskripsi" id="deskripsi" class="form-control rounded-4 px-3 py-2" rows="4" required></textarea>
            </div>

            <div class="d-flex justify-content-start gap-2">
              <a href="{{ route('materi.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
              </a>
              <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="fas fa-save me-1"></i> Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery & Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Inisialisasi Select2 -->
<script>
  $(document).ready(function () {
    $('.select2').select2({
      placeholder: "-- Pilih Mata Pelajaran --",
      allowClear: true
    });
  });
</script>
@endsection
