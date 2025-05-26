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
        <div class="col">
          <h1 class="m-0 text-dark">Tambah Siswa</h1>
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Tambah Siswa</li>
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
          <h5 class="mb-0">Form Tambah Siswa</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('profil_siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
              <label for="user_id" class="form-label">Nama Siswa</label>
              <select name="user_id" class="form-control rounded-pill px-3 py-2 select2"
                @if(auth()->user()->role_name === 'siswa') disabled @endif required>

                <option value="">-- Pilih Siswa --</option>

                @foreach ($users as $user)
                  <option value="{{ $user->id }}"
                    {{ (old('user_id', $siswa->user_id ?? auth()->user()->id) == $user->id) ? 'selected' : '' }}>
                    {{ $user->name }} - {{ $user->email }}
                  </option>
                @endforeach
              </select>

              @if(auth()->user()->role_name === 'siswa')
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
              @endif
            </div>

            <div class="mb-3">
              <label for="nisn" class="form-label">NISN</label>
              <input type="text" name="nisn" class="form-control rounded-pill px-3 py-2" required>
            </div>

            <div class="mb-4">
              <label for="poto" class="form-label">Foto</label>
              <input type="file" name="poto" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="d-flex justify-content-start gap-2">
              <a href="{{ route('profil_siswa.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Batal
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

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery & Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Initialize Select2 -->
<script>
  $(document).ready(function () {
    $('.select2').select2({
      placeholder: "-- Pilih Siswa --",
      allowClear: true
    });
  });
</script>
@endsection
