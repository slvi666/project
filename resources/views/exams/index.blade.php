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
              <a href="javascript:void(0);" class="btn btn-light text-primary fw-bold shadow-sm rounded-pill px-4 text-" onclick="confirmAddExam()">
                Tambah jadwal Ujian
              </a>
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

              <div class="mb-3">
                <input type="text" id="search" placeholder="🔍 Cari Ujian..." class="form-control w-50 shadow-sm rounded-pill px-3">
              </div>

              <div class="table-responsive">
                <table id="examsTable" class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th>No</th>
                      <th>Nama Ujian</th>
                      <th>Mata Pelajaran</th>
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
                        <td>{{ $exam->exam_title }}</td>
                        <td>{{ $exam->subject->subject_name }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $exam->question_type)) }}</td>
                        <td>{{ $exam->duration }} menit</td>
                        <td>{{ $exam->start_time ? \Carbon\Carbon::parse($exam->start_time)->format('Y-m-d H:i') : '-' }}</td>
                        <td>{{ $exam->end_time ? \Carbon\Carbon::parse($exam->end_time)->format('Y-m-d H:i') : '-' }}</td>
<td class="text-center">
  <a href="{{ route('exams.show', $exam->id) }}" class="btn btn-info btn-sm rounded-pill me-1 shadow-sm" title="Lihat">
    <i class="fas fa-eye"></i>
  </a>

  <a href="javascript:void(0);" onclick="confirmEdit('{{ route('exams.edit', $exam->id) }}')" class="btn btn-warning btn-sm rounded-pill me-1 shadow-sm" title="Edit">
    <i class="fas fa-edit"></i>
  </a>

  <a href="{{ route('questions.index', $exam->id) }}" class="btn btn-primary btn-sm rounded-pill me-1 shadow-sm" title="Kelola Soal">
    <i class="fas fa-tasks"></i>
  </a>

  <a href="{{ route('exam.start', $exam->id) }}" class="btn btn-success btn-sm rounded-pill me-1 shadow-sm" title="Kerjakan Ujian">
    <i class="fas fa-play"></i> <!-- icon "play" untuk mulai -->
  </a>

  <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)" title="Hapus">
      <i class="fas fa-trash"></i>
    </button>
  </form>
</td>

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
</script>
@endsection
