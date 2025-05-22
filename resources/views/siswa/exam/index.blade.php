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
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              <h3 class="card-title m-0">Daftar Hasil Ujian</h3>
            </div>

            <div class="card-body">
              {{-- Search --}}
              <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" id="search" placeholder="🔍 Cari..." class="form-control w-50 shadow-sm rounded-pill px-3">
              </div>

              <div class="table-responsive">
                @php
                  // Mengelompokkan hasil ujian berdasarkan jenis ujian
                  $groupedExams = $studentExams->groupBy(function($exam) {
                    return ucfirst(str_replace('_', ' ', $exam->exam->question_type));
                  });
                @endphp
                @if($studentExams->count() > 0)
                  @foreach($groupedExams as $questionType => $exams)
                    <h5 class="mt-4 mb-2">{{ $questionType }}</h5>
                    <table class="table table-bordered table-striped align-middle">
                      <thead class="bg-primary text-white text-center">
                        <tr>
                          <th style="width: 5%;">No</th>
                          <th>Nama Siswa</th>
                          <th>Judul Ujian</th>
                          <th>Dimulai</th>
                          <th>Selesai</th>
                          <th>Skor</th>
                          @if (auth()->user()->role_name === 'guru' || auth()->user()->role_name === 'Admin')
                          <th>Aksi</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($exams as $index => $exam)
                          <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $exam->siswa->user->name ?? 'Nama tidak tersedia' }}</td>
                            <td>{{ $exam->exam->exam_title }}</td>
                            <td>
                              {{ $exam->started_at ? \Carbon\Carbon::parse($exam->started_at)->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') : '-' }}
                            </td>
                            <td>
                              {{ $exam->finished_at ? \Carbon\Carbon::parse($exam->finished_at)->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') : '-' }}
                            </td>
                            <td>{{ $exam->score !== null ? $exam->score : 'Belum dinilai' }}</td>
                            @if (auth()->user()->role_name === 'guru' || auth()->user()->role_name === 'Admin')
                            <td class="text-center">
                              @if($exam->exam->question_type === 'esai')
                                <a href="javascript:void(0)" 
                                  onclick="confirmEdit('{{ route('siswa.exam.edit', $exam->id) }}')" 
                                  class="btn btn-sm btn-warning rounded-circle shadow-sm" 
                                  title="Edit">
                                  <i class="fas fa-edit"></i>
                                </a>
                              @endif
                            </td>
                            @endif
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  @endforeach
                @else
                  <div class="text-center">Tidak ada data hasil ujian.</div>
                @endif
              </div>

              <div id="pagination" class="mt-3 text-center"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");

    searchInput.addEventListener("keyup", function () {
      const filter = searchInput.value.toLowerCase();
      const tables = document.querySelectorAll('.table-responsive table');
      tables.forEach(table => {
        const rows = table.querySelectorAll("tbody tr");
        let anyVisible = false;
        rows.forEach(row => {
          const text = row.textContent.toLowerCase();
          if(text.includes(filter)) {
            row.style.display = "";
            anyVisible = true;
          } else {
            row.style.display = "none";
          }
        });
        // Sembunyikan table jika semua baris tidak ada yang cocok
        table.style.display = anyVisible ? "" : "none";

        // Sembunyikan judul group jika tabel tidak tampil
        const heading = table.previousElementSibling;
        if(heading) {
          heading.style.display = anyVisible ? "" : "none";
        }
      });
    });
  });

  function confirmEdit(url) {
    Swal.fire({
      title: 'Nilai Jawaban Esai?',
      text: 'Anda akan diarahkan ke halaman penilaian esai siswa.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Nilai Sekarang',
      cancelButtonText: 'Batal',
      reverseButtons: false,
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
</script>
@endsection
