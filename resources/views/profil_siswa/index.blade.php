@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Siswa</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Siswa</li>
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
              <h3 class="card-title m-0">Daftar Siswa</h3>
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
                <input type="text" id="searchInput" placeholder="🔍 Cari siswa..." class="form-control w-50 shadow-sm rounded-pill px-3">
                @if ((auth()->user()->role_name === 'siswa' && !$siswaExists) || auth()->user()->role_name === 'Admin')
                <a href="javascript:void(0)" onclick="confirmAdd('{{ route('profil_siswa.create') }}')" 
                  class="btn btn-primary fw-bold shadow-sm rounded-pill px-4">
                  <i class="fas fa-plus-circle me-1"></i> Tambah Siswa
                </a>
                @endif
              </div>

              @php
                $grouped = $siswa->groupBy(function($item) {
                    return $item->subject->class_name ?? 'Tidak Diketahui';
                });
              @endphp

              @foreach($grouped as $className => $students)
              <div class="mb-4 student-group">
                <h5 class="fw-bold text-primary mt-4 mb-2 pb-2 border-bottom border-primary">Kelas {{ $className }}</h5>

                <div class="table-responsive">
                  <table class="table table-bordered table-striped align-middle student-table">
                    <thead class="bg-primary text-white text-center">
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NISN</th>
                        <th>Foto</th>
                        <th style="width: 25%;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($students as $index => $data)
                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $data->user->name }}</td>
                        <td>{{ $data->user->email }}</td>
                        <td>{{ $data->nisn }}</td>
                        <td class="text-center">
                          @if($data->poto)
                            <img src="{{ asset('storage/' . $data->poto) }}" width="50" class="rounded-circle">
                          @else
                            <span class="text-muted">Tidak ada foto</span>
                          @endif
                        </td>
                        <td class="text-center">
                          <a href="javascript:void(0)" onclick="confirmView('{{ route('profil_siswa.show', $data->id) }}')" 
                            class="btn btn-info btn-sm rounded-pill shadow-sm me-1">
                            <i class="fas fa-eye"></i>
                          </a>
                          @if (auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'siswa')
                          <button class="btn btn-warning btn-sm rounded-pill shadow-sm me-1"
                                  onclick="confirmEdit('{{ route('profil_siswa.edit', $data->id) }}')">
                            <i class="fas fa-edit"></i>
                          </button>
                          @endif
                          @if (auth()->user()->role_name === 'Admin')
                          <form action="{{ route('profil_siswa.destroy', $data->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    class="btn btn-danger btn-sm rounded-pill shadow-sm me-1"
                                    onclick="confirmDelete(this.form)">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                          @endif
                          <a href="{{ route('siswa.print', $data->id) }}" target="_blank"
                            class="btn btn-success btn-sm rounded-pill shadow-sm">
                            <i class="fas fa-print"></i>
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

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.min.js"></script>

<!-- Pencarian Global -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const tables = document.querySelectorAll(".student-table");

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

        // Tampilkan atau sembunyikan seluruh grup kelas jika tidak ada baris yang cocok
        const groupContainer = table.closest('.student-group');
        if (groupContainer) {
          groupContainer.style.display = hasVisibleRow ? "" : "none";
        }
      });
    });
  });

  function confirmAdd(url) {
    Swal.fire({
      title: 'Tambah Siswa Baru?',
      text: "Anda akan diarahkan ke halaman tambah siswa.",
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
      title: 'Edit Data Siswa?',
      text: "Anda akan diarahkan ke halaman edit.",
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

  function confirmView(url) {
    Swal.fire({
      title: 'Lihat Detail Siswa?',
      text: "Anda akan diarahkan ke halaman detail siswa.",
      icon: 'info',
      confirmButtonText: 'Lanjutkan'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }

  function confirmDelete(form) {
    Swal.fire({
      title: 'Hapus Data Siswa?',
      text: "Data ini akan dihapus secara permanen!",
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
