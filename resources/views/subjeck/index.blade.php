@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Kelas & Pelajaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Daftar Kelas & Pelajaran</li>
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
              <h3 class="card-title m-0">Daftar Kelas & Pelajaran</h3>
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

              <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" id="searchInput" placeholder="🔍 Cari ..." class="form-control w-50 shadow-sm rounded-pill px-3">
                <a href="javascript:void(0);" class="btn btn-primary fw-bold shadow-sm rounded-pill px-4" onclick="confirmAdd()">
                  <i class="fas fa-plus-circle me-1"></i> Tambah Kelas & Pelajaran
                </a>
              </div>

              @php
                $groupedSubjects = $subjects->groupBy('class_name');
              @endphp

              @foreach($groupedSubjects as $className => $items)
              <div class="mb-4 subject-group">
                <h5 class="fw-bold text-primary mt-4 mb-2 pb-2 border-bottom border-primary">Kelas {{ $className }}</h5>

                <div class="table-responsive">
                  <table class="table table-bordered table-striped align-middle subject-table">
                    <thead class="bg-primary text-white text-center">
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th>Mata Pelajaran</th>
                        <th style="width: 20%;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($items as $index => $subject)
                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $subject->subject_name }}</td>
                        <td class="text-center">
                          <a href="javascript:void(0);" onclick="confirmShow('{{ route('subjects.show', $subject->id) }}')" class="btn btn-info btn-sm rounded-pill me-1 shadow-sm" title="Lihat">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="javascript:void(0);" onclick="confirmEdit('{{ route('subjects.edit', $subject->id) }}')" class="btn btn-warning btn-sm rounded-pill me-1 shadow-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>
                          
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              @endforeach

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.min.js"></script>

<!-- Global Search Script -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const tables = document.querySelectorAll(".subject-table");

    searchInput.addEventListener("keyup", function () {
      const filter = this.value.toLowerCase();

      tables.forEach(table => {
        const rows = table.querySelectorAll("tbody tr");
        let hasVisibleRow = false;

        rows.forEach(row => {
          const text = row.textContent.toLowerCase();
          const match = text.includes(filter);
          row.style.display = match ? "" : "none";
          if (match) hasVisibleRow = true;
        });

        const groupContainer = table.closest('.subject-group');
        if (groupContainer) {
          groupContainer.style.display = hasVisibleRow ? "" : "none";
        }
      });
    });
  });

  function confirmAdd() {
    Swal.fire({
      title: 'Tambah Kelas & Pelajaran?',
      text: "Apakah Anda ingin menambahkan kelas & pelajaran baru?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, tambah!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "{{ route('subjects.create') }}";
      }
    });
  }

  function confirmEdit(url) {
    Swal.fire({
      title: 'Edit Kelas & Pelajaran?',
      text: "Anda akan diarahkan ke halaman edit kelas & pelajaran.",
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

  function confirmShow(url) {
    Swal.fire({
      title: 'Lihat Detail Kelas & Pelajaran?',
      text: "Anda akan diarahkan ke halaman detail kelas & pelajaran.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Lihat',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }


</script>
@endsection
