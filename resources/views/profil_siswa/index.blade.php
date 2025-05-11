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
            <li class="breadcrumb-item active">Daftar Siswa</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Daftar Siswa</h3>
              @if (auth()->user()->role_name === 'Admin')
              <div class="card-tools">
                <a href="javascript:void(0)" onclick="confirmAdd('{{ route('profil_siswa.create') }}')" class="btn btn-success shadow-sm">
                  <i class="fas fa-user-plus"></i> Tambah Siswa
                </a>
              </div>
              @endif
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

              <div class="card">
                <div class="card-body">
                  @if (auth()->user()->role_name === 'Admin')
                  <div class="mb-3 d-flex justify-content-between align-items-center">
                    <input type="text" id="searchInput" placeholder="🔍 Cari siswa..." class="form-control w-50 shadow-sm">
                  </div>
                  @endif

              {{-- <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari siswa..."> --}}

              <table id="studentsTable" class="table table-bordered table-striped">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NISN</th>
                    <th>Kelas</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($siswa as $index => $data)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $data->user->name }}</td>
                      <td>{{ $data->user->email }}</td>
                      <td>{{ $data->nisn }}</td>
                      <td>{{ $data->subject->class_name ?? '-' }}</td>
                      <td>
                        @if($data->poto)
                          <img src="{{ asset('storage/' . $data->poto) }}" width="50">
                        @else
                          Tidak ada foto
                        @endif
                      </td>
                      <td>
                        <a href="javascript:void(0)" onclick="confirmView('{{ route('profil_siswa.show', $data->id) }}')" class="btn btn-info btn-sm rounded-pill shadow-sm me-1">
                          <i class="fas fa-eye"></i> Detail
                        </a>
                        @if (auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'siswa')
                        <button class="btn btn-warning btn-sm rounded-pill shadow-sm me-1"
                                onclick="confirmEdit('{{ route('profil_siswa.edit', $data->id) }}')">
                          <i class="fas fa-edit"></i> Edit
                        </button>
                      @endif
                    
                      @if (auth()->user()->role_name === 'Admin')
                        <form action="{{ route('profil_siswa.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="button"
                                  class="btn btn-danger btn-sm rounded-pill shadow-sm"
                                  onclick="confirmDelete(this.form)">
                            <i class="fas fa-trash"></i> Hapus
                          </button>
                        </form>
                      @endif
                      <a href="{{ route('siswa.print', $data->id) }}" target="_blank" class="btn btn-success btn-sm rounded-pill shadow-sm">
                        <i class="fas fa-print"></i> Print
                    </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <div id="paginationContainer" class="mt-3 text-center"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    let table = document.getElementById("studentsTable");
    let searchInput = document.getElementById("searchInput");
    let rows = table.getElementsByTagName("tr");
    let currentPage = 1;
    let rowsPerPage = 5;
    let pagination = document.getElementById("paginationContainer");

    function showPage(page) {
      let start = (page - 1) * rowsPerPage + 1;
      let end = start + rowsPerPage;

      for (let i = 1; i < rows.length; i++) {
        rows[i].style.display = (i >= start && i < end) ? "table-row" : "none";
      }
    }

    function setupPagination() {
      pagination.innerHTML = "";
      let pageCount = Math.ceil((rows.length - 1) / rowsPerPage);
      for (let i = 1; i <= pageCount; i++) {
        let btn = document.createElement("button");
        btn.innerText = i;
        btn.className = "btn btn-sm btn-secondary mx-1";
        btn.onclick = function() { currentPage = i; showPage(i); };
        pagination.appendChild(btn);
      }
    }

    searchInput.addEventListener("keyup", function() {
      let filter = searchInput.value.toLowerCase();
      for (let i = 1; i < rows.length; i++) {
        let text = rows[i].textContent.toLowerCase();
        rows[i].style.display = text.includes(filter) ? "table-row" : "none";
      }
    });

    showPage(1);
    setupPagination();
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

  function confirmDelete(form) {
    Swal.fire({
      title: 'Anda yakin?',
      text: "Data ini akan dihapus!",
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

  function confirmEdit(url) {
    Swal.fire({
      title: 'Anda yakin ingin mengedit?',
      text: "Anda akan diarahkan ke halaman edit.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Ya, lanjutkan!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.location.href = url;
      }
    });
  }

  function confirmView(url) {
    Swal.fire({
      title: 'Lihat Detail Siswa?',
      text: "Anda akan diarahkan ke halaman detail.",
      icon: 'info',
      confirmButtonText: 'Lanjutkan'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }
</script>
@endsection
