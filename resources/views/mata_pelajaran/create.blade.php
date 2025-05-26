@extends('adminlte.layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
.select2-selection__rendered { line-height: 24px !important; }
.select2-selection__arrow { height: 36px !important; top: 1px !important; right: 10px; }
.select2-container--default.select2-container--focus .select2-selection--single {
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}
</style>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Tambah Mata Pelajaran</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('mata-pelajaran.index') }}">Mata Pelajaran</a></li>
            <li class="breadcrumb-item active">Tambah</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Form Tambah Mata Pelajaran</h5>
        </div>
        <div class="card-body">

          @if ($errors->any())
            <script>
              Swal.fire({
                title: 'Terjadi Kesalahan!',
                html: `<ul>{!! implode('', $errors->all('<li>:message</li>')) !!}</ul>`,
                icon: 'error',
                confirmButtonText: 'OK'
              });
            </script>
          @endif

          <form action="{{ route('mata-pelajaran.store') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label for="subject_id" class="form-label">Mata Pelajaran</label>
              <select name="subject_id" id="subject_id" class="form-control select2" required>
                <option value="">-- Pilih --</option>
                @foreach ($subjects as $subject)
                  <option value="{{ $subject->id }}">{{ $subject->subject_name }} ({{ $subject->class_name }})</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="guru_id" class="form-label">Guru</label>
              <select name="guru_id" id="guru_id" class="form-control select2" required>
                <option value="">-- Pilih Guru --</option>
                @foreach ($gurus as $guru)
                  <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="filter_kelas" class="form-label">Filter Kelas</label>
              <select id="filter_kelas" class="form-control">
                <option value="all">-- Tampilkan Semua --</option>
                @php
                  $kelas = $siswa->pluck('subject.class_name')->unique();
                @endphp
                @foreach ($kelas as $kelasItem)
                  <option value="{{ $kelasItem }}">{{ $kelasItem }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Siswa</label>
              <div class="checkbox-group">
                @foreach ($siswa as $s)
                  <div class="form-check siswa-item" data-kelas="{{ $s->subject->class_name }}">
                    <input class="form-check-input" type="checkbox" name="siswa_ids[]" value="{{ $s->id }}" id="siswa_{{ $s->id }}">
                    <label class="form-check-label" for="siswa_{{ $s->id }}">
                      {{ $s->user->name }} ({{ $s->subject->class_name }})
                    </label>
                  </div>
                @endforeach
              </div>
              <small class="text-muted">* Pilih satu atau lebih siswa</small>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                <input type="time" name="waktu_mulai" class="form-control rounded-pill px-3 py-2" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="waktu_berakhir" class="form-label">Waktu Berakhir</label>
                <input type="time" name="waktu_berakhir" class="form-control rounded-pill px-3 py-2" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="hari" class="form-label">Hari</label>
              <select name="hari" class="form-control rounded-pill px-3 py-2" required>
                @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                  <option value="{{ $hari }}">{{ $hari }}</option>
                @endforeach
              </select>
            </div>

            <div class="d-flex justify-content-start gap-2">
              <a href="{{ route('mata-pelajaran.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
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


<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery & Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>

  $(document).ready(function () {
    $('.select2').select2({
      placeholder: '-- Pilih --',
      allowClear: true
    });

    $('#filter_kelas').on('change', function () {
      const selected = this.value;
      document.querySelectorAll('.siswa-item').forEach(function (item) {
        item.style.display = selected === 'all' || item.getAttribute('data-kelas') === selected ? 'block' : 'none';
      });
    });
  });
</script>
@endsection
