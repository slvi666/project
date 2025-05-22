@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary"><i class="fas fa-question-circle me-1"></i> Daftar Soal - {{ $exam->exam_title }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('exams.index') }}">Ujian</a></li>
            <li class="breadcrumb-item active">Daftar Soal</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-lg rounded">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
          <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i>Soal untuk Ujian: {{ $exam->exam_title }}</h3>
        </div>

        <div class="card-body">
          @if(session('success'))
            <script>
              Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
              });
            </script>
          @endif

          <div class="mb-4 d-flex justify-content-between align-items-center">
            <input type="text" id="search" placeholder="🔍 Cari Soal..." class="form-control w-50 shadow-sm rounded-pill px-4 py-2">
            <a href="javascript:void(0)" onclick="confirmAdd('{{ route('questions.create', $exam->id) }}')" class="btn btn-outline-primary fw-semibold shadow-sm rounded-pill px-4 py-2">
              <i class="fas fa-plus me-1"></i> Tambah Soal
            </a>
          </div>

         <div class="table-responsive">
          <table id="soalTable" class="table table-hover table-bordered table-striped align-middle">
            <thead class="table-primary text-center align-middle">
              <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">Soal</th>
                <th style="width: 15%;">Jenis</th>
                <th style="width: 25%;">Jawaban Benar</th>
                <th style="width: 20%;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($questions as $index => $question)
                <tr>
                  <td class="text-center">{{ $index + 1 }}</td>
                  <td>{{ Str::limit($question->question_text, 80, '...') }}</td>
                  <td class="text-center">
                    <span class="badge {{ $question->type === 'multiple' ? 'bg-primary' : 'bg-warning text-dark' }}">
                      {{ ucfirst($question->type) }}
                    </span>
                  </td>
                  <td>{{ Str::limit($question->correct_answer, 50, '...') }}</td>
                  <td class="text-center">
                    <button onclick="confirmEdit('{{ route('questions.edit', [$exam->id, $question->id]) }}')" class="btn btn-sm btn-warning rounded-pill me-1">
                      <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('questions.destroy', [$exam->id, $question->id]) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-sm btn-danger rounded-pill" onclick="confirmDelete(this.form)">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center text-muted">Belum ada soal untuk ujian ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>


          <div id="pagination" class="mt-3 text-center"></div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("soalTable");
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
        btn.className = "btn btn-sm btn-outline-secondary mx-1 rounded-circle";
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

  function confirmAdd(url) {
    Swal.fire({
      title: 'Tambah Soal Baru?',
      text: "Anda akan diarahkan ke halaman tambah soal.",
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

  function confirmEdit(url) {
    Swal.fire({
      title: 'Edit Soal?',
      text: "Anda akan diarahkan ke halaman edit soal.",
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

  function confirmDelete(form) {
    Swal.fire({
      title: 'Yakin ingin hapus?',
      text: "Soal ini akan dihapus secara permanen.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  }
</script>
@endsection
