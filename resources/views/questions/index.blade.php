@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Soal - {{ $exam->exam_title }}</h1>
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
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
          <h3 class="card-title m-0">Soal untuk Ujian: {{ $exam->exam_title }}</h3>
          <a href="{{ route('questions.create', $exam->id) }}" class="btn btn-light btn-sm fw-bold shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Tambah Soal
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
              });
            </script>
          @endif

          <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
              <thead class="bg-primary text-white text-center">
                <tr>
                  <th>Soal</th>
                  <th>Jenis Soal</th>
                  <th style="width: 20%;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($questions as $question)
                  <tr>
                    <td>{{ $question->question_text }}</td>
                    <td>{{ ucfirst($question->type) }}</td>
                    <td class="text-center">
                      <a href="{{ route('questions.edit', [$exam->id, $question->id]) }}" class="btn btn-warning btn-sm rounded-pill me-1 shadow-sm" title="Edit">
                        <i class="fas fa-edit"></i>
                      </a>
                      <form action="{{ route('questions.destroy', [$exam->id, $question->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)" title="Hapus">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center">Belum ada soal untuk ujian ini.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.min.js"></script>
<script>
  function confirmDelete(form) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
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
