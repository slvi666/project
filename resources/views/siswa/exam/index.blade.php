@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Hasil Ujian Anda</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Hasil Ujian</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-lg rounded">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
              <h3 class="card-title m-0">Daftar Hasil Ujian</h3>
            </div>

            <div class="card-body">
              {{-- Search Bar --}}
              <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" id="search" placeholder="🔍 Cari ..." class="form-control w-50 shadow-sm rounded-pill px-3">
                <button id="clearSearch" class="btn btn-outline-danger rounded-pill px-3" style="display: none;">
                  <i class="fas fa-times me-1"></i> Bersihkan
                </button>
              </div>

              @php
                $groupedExams = $studentExams->groupBy(fn($exam) => ucfirst(str_replace('_', ' ', $exam->exam->question_type)));
              @endphp

              @if($studentExams->count() > 0)
                <div class="table-responsive">
                  @foreach($groupedExams as $questionType => $exams)
                    <h5 class="mt-4 mb-3 border-bottom pb-1 bg-light px-3">{{ $questionType }}</h5>
                    <table class="table table-bordered table-striped align-middle table-hover">
                      <thead class="bg-primary text-white text-center">
                        <tr>
                          <th style="width: 5%;">No</th>
                          <th>Nama Siswa</th>
                          <th>Judul Ujian</th>
                          <th>Mata Pelajaran</th>
                          <th>Kelas</th>
                          <th>Guru</th> 
                          <th>Dimulai</th>
                          <th>Selesai</th>
                          <th>Skor</th>
                          <th>Aksi</th>
                          {{-- @if (in_array(auth()->user()->role_name, ['guru']) && strtolower($questionType) === 'esai')
                            <th>Aksi</th>
                          @endif --}}
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($exams as $index => $exam)
                          @php
                            $score = $exam->score;
                            $scoreText = $score ?? 'Belum dinilai';
                            $scoreBadgeClass = match(true) {
                              is_null($score) => 'badge-secondary',
                              $score < 50 => 'badge-danger',
                              $score < 75 => 'badge-warning',
                              $score < 90 => 'badge-success-soft',
                              default => 'badge-success'
                            };
                            $started = $exam->started_at ? \Carbon\Carbon::parse($exam->started_at)->translatedFormat('d F Y H:i') : '-';
                            $finished = $exam->finished_at ? \Carbon\Carbon::parse($exam->finished_at)->translatedFormat('d F Y H:i') : '-';
                          @endphp
                          <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $exam->siswa->user->name ?? 'Nama tidak tersedia' }}</td>
                            <td>{{ $exam->exam->exam_title }}</td>
                            <td>{{ $exam->exam->subject->subject_name ?? '-' }}</td>
                            <td>{{ $exam->exam->subject->class_name ?? '-' }}</td>
                            <td>{{ $exam->exam->guru->name ?? '-' }}</td>
                            <td>{{ $started }}</td>
                            <td>{{ $finished }}</td>
                            
                            <td class="text-center">
                              <span class="badge {{ $scoreBadgeClass }}">{{ $scoreText }}</span>
                            </td>

                              <td class="text-center">
                                @if (in_array(auth()->user()->role_name, ['guru']) && strtolower($questionType) === 'esai')
                                <a href="javascript:void(0)" onclick="confirmEdit('{{ route('siswa.exam.edit', $exam->id) }}')" class="btn btn-warning btn-sm rounded-pill shadow-sm">
                                  <i class="fas fa-pen-to-square me-1"></i> Review
                                </a>
                               @endif
                                <button onclick="confirmShow('{{ route('siswa.exam.show', $exam->id) }}')" class="btn btn-info btn-sm rounded-pill shadow-sm">
                                  <i class="fas fa-eye me-1"></i> Show
                                </button>

                              </td>

                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  @endforeach
                </div>
              @else
                <div class="text-center text-muted fst-italic p-4">Tidak ada data hasil ujian.</div>
              @endif
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<style>
  .table-hover tbody tr:hover { background-color: #f1f5f9; }
  .badge-success { background-color: #28a745; }
  .badge-success-soft { background-color: #d4edda; color: #155724; }
  .badge-warning { background-color: #ffc107; color: #212529; }
  .badge-danger { background-color: #dc3545; }
  .badge-secondary { background-color: #6c757d; }
  #search:focus { box-shadow: 0 0 8px rgba(59, 130, 246, 0.8); }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const clearBtn = document.getElementById("clearSearch");

    searchInput.addEventListener("keyup", function () {
      const filter = searchInput.value.toLowerCase();
      const tables = document.querySelectorAll('.table-responsive table');
      let hasInput = filter.length > 0;

      tables.forEach(table => {
        const rows = table.querySelectorAll("tbody tr");
        let anyVisible = false;
        rows.forEach(row => {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(filter) ? "" : "none";
          if (text.includes(filter)) anyVisible = true;
        });
        table.style.display = anyVisible ? "" : "none";
        const heading = table.previousElementSibling;
        if (heading) heading.style.display = anyVisible ? "" : "none";
      });

      clearBtn.style.display = hasInput ? "inline-block" : "none";
    });

    clearBtn.addEventListener("click", function () {
      searchInput.value = "";
      searchInput.dispatchEvent(new Event('keyup'));
      searchInput.focus();
    });
  });

  function confirmEdit(url) {
    Swal.fire({
      title: 'Review Jawaban Esai?',
      text: 'Anda akan diarahkan ke halaman penilaian esai siswa.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Nilai Sekarang',
      cancelButtonText: 'Batal',
      customClass: {
        confirmButton: 'btn btn-success me-2',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }

  function confirmShow(url) {
  Swal.fire({
    title: 'Lihat Detail Ujian?',
    text: 'Anda akan melihat detail hasil ujian siswa.',
    icon: 'info',
    showCancelButton: true,
    confirmButtonText: 'Lihat Sekarang',
    cancelButtonText: 'Batal',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-secondary'
    },
    buttonsStyling: false
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}

</script>
@endsection
