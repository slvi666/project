@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Jadwal Ujian</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Daftar jadwal Ujian</li>
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
              <h3 class="card-title m-0">Daftar Jadwal Ujian</h3>
            </div>

            <div class="card-body">
              @if(session('success'))
                <script>
                  Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                  }).then(() => {
                    window.location.reload();
                  });
                </script>
              @endif
             
              {{-- Search --}}
              <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" id="search" placeholder="🔍 Cari Ujian..." class="form-control w-50 shadow-sm rounded-pill px-3">
                
                @if (auth()->user()->role_name === '#' || auth()->user()->role_name === 'Admin')
                <a href="javascript:void(0)" onclick="confirmAddExam()" 
                  class="btn btn-primary fw-bold shadow-sm rounded-pill px-4 ms-3">
                  <i class="fas fa-plus-circle me-1"></i> Tambah Jadwal Ujian
                </a>
                @endif
              </div>
              </div>

              <div class="table-responsive">
                <table id="examsTable" class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th>No</th>
                       <th>Guru</th>  <!-- Tambahan kolom guru -->
                      <th>Nama Ujian</th>
                      <th>Mata Pelajaran</th>
                      <th>Kelas</th>
                      <th>Jenis Soal</th>
                      <th>Durasi</th>
                      <th>Waktu Mulai</th>
                      <th>Waktu Selesai</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($exams as $index => $exam)
                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                         <td>{{ $exam->guru ? $exam->guru->name : '-' }}</td> <!-- Menampilkan nama guru -->
                        <td>{{ $exam->exam_title }}</td>
                        <td>{{ $exam->subject->subject_name }}</td>
                        <td>{{ $exam->subject->class_name }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $exam->question_type)) }}</td>
                        <td>{{ $exam->duration }} menit</td>
                        <td>
                            {{ $exam->start_time 
                                ? \Carbon\Carbon::parse($exam->start_time)->translatedFormat('l, d F Y H:i') 
                                : '-' 
                            }}
                        </td>
                        <td>
                            {{ $exam->end_time 
                                ? \Carbon\Carbon::parse($exam->end_time)->translatedFormat('l, d F Y H:i') 
                                : '-' 
                            }}
                        </td>

                        @php
                            $userRole = auth()->user()->role_name;
                        @endphp

                        <td class="text-center">
                        <a href="javascript:void(0);" 
                          onclick="confirmViewExam('{{ route('exams.show', $exam->id) }}')" 
                          class="btn btn-info btn-sm rounded-pill me-1 shadow-sm" 
                          title="Lihat">
                          <i class="fas fa-eye"></i>
                        </a>
                         @if ($userRole === 'siswa')
                       <a href="javascript:void(0);" 
   onclick="confirmStartExam(
       '{{ route('exam.start', $exam->id) }}', 
       '{{ $exam->exam_title }}', 
       '{{ $exam->duration }}', 
       '{{ $exam->start_time }}', 
       '{{ $exam->end_time }}'
    )" 
   class="btn btn-success btn-sm rounded-pill me-1 shadow-sm" 
   title="Kerjakan Ujian">
  <i class="fas fa-play"></i>
</a>


                        @endif
                        @if (in_array(auth()->user()->role_name, ['guru', 'Admin']))
                      <button type="button" class="btn btn-primary btn-sm rounded-pill me-1 shadow-sm" 
                        onclick="confirmManageQuestions('{{ route('questions.index', $exam->id) }}')" title="Kelola Soal">
                        <i class="fas fa-tasks"></i>
                      </button>
                        @endif
                        @if (auth()->user()->role_name === 'Admin')
                        <a href="javascript:void(0);" onclick="confirmEdit('{{ route('exams.edit', $exam->id) }}')" class="btn btn-warning btn-sm rounded-pill me-1 shadow-sm" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)" title="Hapus">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </td>
                       @endif

                      </tr>
                    @endforeach
                  </tbody>
                </table>
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
    const table = document.getElementById("examsTable");
    const searchInput = document.getElementById("search");
    const rows = table.getElementsByTagName("tr");
    const pagination = document.getElementById("pagination");
    let currentPage = 1;
    const rowsPerPage = 5;

    function showPage(page) {
      const start = (page - 1) * rowsPerPage + 1;
      const end = start + rowsPerPage;
      for (let i = 1; i < rows.length; i++) {
        rows[i].style.display = (i >= start && i < end) ? "" : "none";
      }
    }

    function setupPagination() {
      pagination.innerHTML = "";
      const pageCount = Math.ceil((rows.length - 1) / rowsPerPage);
      for (let i = 1; i <= pageCount; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        btn.className = "btn btn-sm btn-secondary mx-1";
        btn.onclick = () => {
          currentPage = i;
          showPage(i);
        };
        pagination.appendChild(btn);
      }
    }

    searchInput.addEventListener("keyup", function () {
      const filter = searchInput.value.toLowerCase();
      for (let i = 1; i < rows.length; i++) {
        const text = rows[i].textContent.toLowerCase();
        rows[i].style.display = text.includes(filter) ? "" : "none";
      }
    });

    showPage(currentPage);
    setupPagination();
  });

  function confirmDelete(form) {
    Swal.fire({
      title: 'Yakin ingin menghapus ujian ini?',
      text: "Data tidak dapat dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  }

  function confirmEdit(url) {
    Swal.fire({
      title: 'Edit Ujian?',
      text: "Anda akan diarahkan ke halaman edit ujian.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Lanjutkan',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }

  function confirmAddExam() {
    Swal.fire({
      title: 'Tambah Ujian Baru?',
      text: "Apakah Anda ingin menambahkan ujian baru?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Tambah!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "{{ route('exams.create') }}";
      }
    });
  }

  function confirmManageQuestions(url) {
  Swal.fire({
    title: 'Kelola Soal?',
    text: "Anda akan diarahkan ke halaman pengelolaan soal.",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Lanjutkan!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}

function confirmViewExam(url) {
  Swal.fire({
    title: 'Lihat Ujian?',
    text: "Anda akan diarahkan untuk melihat detail ujian ini.",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Lihat',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}

function confirmStartExam(url, examTitle, duration, startTime, endTime) {
  const now = new Date();
  const examStart = new Date(startTime);
  const examEnd = new Date(endTime);

  if (now < examStart) {
    Swal.fire({
      icon: 'warning',
      title: 'Ujian Belum Dimulai',
      text: `Ujian "${examTitle}" belum bisa dimulai. Waktu mulai ujian adalah ${examStart.toLocaleString()}.`,
      confirmButtonText: 'OK'
    });
    return;
  }

  if (now > examEnd) {
    Swal.fire({
      icon: 'error',
      title: 'Waktu Ujian Telah Berakhir',
      text: `Maaf, ujian "${examTitle}" sudah tidak bisa diikuti karena sudah melewati tanggal selesai ujian.`,
      confirmButtonText: 'OK'
    });
    return;
  }

  // kalau sudah lewat pengecekan waktu, tampilkan konfirmasi mulai ujian seperti biasa
  Swal.fire({
    title: `<strong>Mulai Ujian: <u>${examTitle}</u></strong>`,
    icon: 'info',
    html: `
      <div style="text-align: left; font-size: 16px; line-height: 1.5;">
        <p><b>Durasi ujian:</b> <span style="color: #1e88e5;">${duration} menit</span></p>
        <p>Pastikan Anda sudah siap dan berada di tempat yang nyaman serta tenang.</p>
        <p><b>Tata cara ujian:</b></p>
        <ul style="margin-left: 1em; color: #555;">
          <li>Jangan keluar dari halaman ujian selama durasi.</li>
          <li>Kerjakan soal dengan jujur dan penuh konsentrasi.</li>
          <li>Pastikan koneksi internet Anda stabil.</li>
          <li>Siapkan alat tulis jika diperlukan.</li>
        </ul>
        <label style="display: flex; align-items: center; margin-top: 1.5em; cursor: pointer; font-weight: 600; user-select: none;">
          <input type="checkbox" id="confirmCheckbox" style="margin-right: 10px; width: 18px; height: 18px; cursor: pointer;">
          Saya sudah membaca dan memahami aturan ujian.
        </label>
      </div>
    `,
    showCancelButton: true,
    confirmButtonText: '<i class="fas fa-play me-2"></i>Mulai Ujian',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#d33',
    didOpen: () => {
      const confirmBtn = Swal.getConfirmButton();
      confirmBtn.disabled = true;

      const checkbox = Swal.getPopup().querySelector('#confirmCheckbox');
      checkbox.addEventListener('change', (e) => {
        confirmBtn.disabled = !e.target.checked;
      });
    },
    allowOutsideClick: false,
    allowEscapeKey: false,
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}



</script>
@endsection
