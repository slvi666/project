
@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Tambah Tugas</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('tugas.index') }}">Daftar Tugas</a></li>
            <li class="breadcrumb-item active">Tambah Tugas</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Form Section -->
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
          <h5 class="mb-0">Form Tambah Tugas</h5>
        </div>

        <form action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="accordion" id="taskAccordion">

              <!-- Accordion 1 -->
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                      aria-expanded="true" aria-controls="collapseOne">
                      <i class="fas fa-pencil-alt"></i> Judul dan Deskripsi Tugas
                    </button>
                  </h5>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                  data-parent="#taskAccordion">
                  <div class="card-body">
                    <div class="form-group">
                      <label>Judul Tugas</label>
                      <input type="text" name="judul_tugas"
                        class="form-control rounded-pill px-3 py-2 shadow-sm" required>
                    </div>
                    <div class="form-group">
                      <label>Deskripsi</label>
                      <textarea name="deskripsi"
                        class="form-control rounded-4 px-3 py-2 shadow-sm"
                        rows="4"></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Accordion 2 -->
              <div class="card">
                <div class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                      data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      <i class="fas fa-users"></i> Informasi Tugas
                    </button>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#taskAccordion">
                  <div class="card-body">
<div class="form-group mb-3">
  <label for="filter_kelas_2">Filter Kelas</label>
  <select id="filter_kelas_2" class="form-control rounded-pill px-3 py-2">
    <option value="all">-- Tampilkan Semua --</option>
    @php
      $kelas = $siswa->pluck('subject.class_name')->unique();
    @endphp
    @foreach ($kelas as $kelasItem)
      <option value="{{ $kelasItem }}">{{ $kelasItem }}</option>
    @endforeach
  </select>
</div>

<div class="form-group">
  <label>Siswa</label><br>
  @foreach($siswa as $s)
    <div class="form-check siswa-item-2" data-kelas="{{ $s->subject->class_name }}">
      <input class="form-check-input" type="checkbox" name="siswa_id[]" value="{{ $s->id }}" id="siswa_{{ $s->id }}">
      <label class="form-check-label" for="siswa_{{ $s->id }}">
        {{ $s->user->name ?? '-' }} ({{ $s->subject->class_name }})
      </label>
    </div>
  @endforeach
</div>


                    <div class="form-group">
                      <label>Guru</label>
                      <input type="hidden" name="guru_id" value="{{ auth()->user()->guru->id }}">
                      <input type="text" class="form-control rounded-pill px-3 py-2 shadow-sm"
                        value="{{ auth()->user()->guru->nama_guru }}" readonly>
                    </div>

                    <div class="form-group">
                      <label>Mata Pelajaran</label>
                      <select name="subject_id" class="form-control rounded-pill px-3 py-2 shadow-sm" required>
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($subject as $sub)
                          <option value="{{ $sub->id }}">{{ $sub->subject_name }} - {{ $sub->class_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Accordion 3 -->
              <div class="card">
                <div class="card-header" id="headingThree">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                      data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      <i class="fas fa-calendar-alt"></i> Tanggal dan File
                    </button>
                  </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#taskAccordion">
                  <div class="card-body">
                    <div class="form-group">
                      <label>Tanggal Diberikan</label>
                      <input type="date" name="tanggal_diberikan"
                        class="form-control rounded-pill px-3 py-2 shadow-sm" required>
                    </div>

                    <div class="form-group">
                      <label>Deadline</label>
                      <input type="date" name="deadline"
                        class="form-control rounded-pill px-3 py-2 shadow-sm" required>
                    </div>

                    <div class="form-group">
                      <label>File Soal</label>
                      <input type="file" name="file_soal"
                        class="form-control rounded-4 px-3 py-2 shadow-sm">
                    </div>
                  </div>
                </div>
              </div>

            </div> <!-- end accordion -->
          </div>

          <div class="card-footer d-flex justify-content-start gap-2">
            <a href="{{ route('tugas.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
              <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
              <i class="fas fa-save me-1"></i> Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const filterKelas2 = document.getElementById('filter_kelas_2');
    const siswaItems2 = document.querySelectorAll('.siswa-item-2');

    filterKelas2.addEventListener('change', function () {
      const selected = this.value;
      siswaItems2.forEach(function (item) {
        const kelas = item.getAttribute('data-kelas');
        item.style.display = (selected === 'all' || kelas === selected) ? 'block' : 'none';
      });
    });
  });
</script>

@endsection
