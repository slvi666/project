@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Formulir Pendaftaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Formulir Pendaftaran</li>
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
              <h3 class="card-title m-0">Data Pendaftar</h3>
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
                <input type="text" id="search" placeholder="🔍 Cari..." class="form-control w-50 shadow-sm rounded-pill px-3">
                @if (auth()->user()->role_name === 'Admin')
                <div class="input-group w-auto shadow-sm rounded-pill" style="overflow: hidden;">
                  <span class="input-group-text bg-white border-0">
                    <i class="fas fa-graduation-cap text-primary"></i>
                  </span>
                  <select id="filterTahun" class="form-select border-0">
                    <option value="">Semua Tahun</option>
                    @foreach ($formulirs->pluck('tahun_lulus')->unique()->sort() as $tahun)
                      <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                  </select>
                </div>
                @endif
                
                @if (auth()->user()->role_name === 'calon_siswa' && !$sudahMengisi)
                <a href="javascript:void(0)" onclick="confirmAdd('{{ route('formulir.create') }}')" 
                  class="btn btn-primary fw-bold shadow-sm rounded-pill px-4 ms-3">
                  <i class="fas fa-plus-circle me-1"></i> Registrasi Pendaftaran
                </a>
                @endif
              </div>

              <div class="table-responsive">
                <table id="formulirTable" class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>NIK</th>
                      <th>TTL</th>
                      <th>Jenis Kelamin</th>
                      <th>No HP</th>
                      <th>Tahun Lulus</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($formulirs as $index => $formulir)
                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $formulir->user->name }}</td>
                        <td>{{ $formulir->user->email }}</td>
                        <td>{{ $formulir->nik }}</td>
                        <td>{{ $formulir->tempat_lahir }}, {{ \Carbon\Carbon::parse($formulir->tanggal_lahir)->format('d-m-Y') }}</td>
                        <td>{{ $formulir->jenis_kelamin }}</td>
                        <td>{{ $formulir->no_hp }}</td>
                        <td>{{ $formulir->tahun_lulus }}</td>
                        <td class="text-center">
                          <span class="badge 
                          {{ 
                            $formulir->status === 'Lulus' ? 'bg-success' : 
                            ($formulir->status === 'Tidak Lulus' ? 'bg-danger' : 'bg-primary') 
                          }}">
                          {{ 
                            $formulir->status === 'Pending' ? 'Menunggu Verifikasi' : $formulir->status 
                          }}
                        </span>
                        </td>
                        <td class="text-center">
                          <a href="javascript:void(0);" 
                            onclick="confirmShow('{{ route('formulir.show', $formulir->id) }}')" 
                            class="btn btn-info btn-sm rounded-pill me-1 shadow-sm">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="javascript:void(0);" 
                            onclick="confirmPrint('{{ route('formulir.cetak', $formulir->id) }}')" 
                            class="btn btn-success btn-sm rounded-pill me-1 shadow-sm">
                            <i class="fa fa-print"></i>
                          </a>
                          <a href="javascript:void(0);" onclick="confirmEdit('{{ route('formulir.edit', $formulir->id) }}')" 
                            class="btn btn-warning btn-sm rounded-pill me-1 shadow-sm">
                            <i class="fas fa-edit"></i>
                          </a>
                          @if (auth()->user()->role_name === 'Admin')
                          <form action="{{ route('formulir.destroy', $formulir->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                          @endif
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

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.min.js"></script>
<script>
  const userRole = "{{ auth()->user()->role_name }}";
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("formulirTable");
    const searchInput = document.getElementById("search");
    const tahunSelect = document.getElementById("filterTahun");
    const rows = table.getElementsByTagName("tr");
    const pagination = document.getElementById("pagination");
    let currentPage = 1;
    const rowsPerPage = 5;

    function showPage(page) {
      const start = (page - 1) * rowsPerPage + 1;
      const end = start + rowsPerPage;
      let rowIndex = 1;
      for (let i = 1; i < rows.length; i++) {
        if (rows[i].style.display !== "none") {
          rows[i].style.display = (rowIndex >= start && rowIndex < end) ? "" : "none";
          rowIndex++;
        }
      }
    }

    function setupPagination() {
      pagination.innerHTML = "";
      let visibleRowCount = 0;
      for (let i = 1; i < rows.length; i++) {
        if (rows[i].style.display !== "none") visibleRowCount++;
      }
      const pageCount = Math.ceil(visibleRowCount / rowsPerPage);
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

    function filterRows() {
      const searchText = searchInput.value.toLowerCase();
      const selectedTahun = tahunSelect.value;
      let visibleRows = 0;

      for (let i = 1; i < rows.length; i++) {
        const rowText = rows[i].textContent.toLowerCase();
        const rowTahun = rows[i].cells[7]?.textContent.trim();
        const matchesSearch = rowText.includes(searchText);
        const matchesTahun = selectedTahun === "" || rowTahun === selectedTahun;

        if (matchesSearch && matchesTahun) {
          rows[i].style.display = "";
          visibleRows++;
        } else {
          rows[i].style.display = "none";
        }
      }

      if (searchText || selectedTahun) {
        pagination.style.display = "none";
      } else {
        pagination.style.display = "block";
        setupPagination();
        showPage(1);
      }
    }

    searchInput.addEventListener("keyup", filterRows);
    tahunSelect?.addEventListener("change", filterRows);

    showPage(currentPage);
    setupPagination();
  });

  function confirmAdd(url) {
    Swal.fire({
      title: 'Silahkan isi formulir berikut?',
      text: "Anda akan diarahkan ke halaman isi formulir pendaftaran.",
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

  // function confirmEdit(url) {
  //   Swal.fire({
  //     title: 'Verifikasi Status?',
  //     text: "Anda akan diarahkan ke halaman pembaharuan",
  //     icon: 'info',
  //     showCancelButton: true,
  //     confirmButtonText: 'Lanjutkan',
  //     cancelButtonText: 'Batal'
  //   }).then((result) => {
  //     if (result.isConfirmed) {
  //       window.location.href = url;
  //     }
  //   });
  // }

  function confirmEdit(url) {
  let title = 'Verifikasi Status?';
  let text = 'Anda akan diarahkan ke halaman pembaharuan';
  let icon = 'info';

  if (userRole === 'calon_siswa') {
    title = 'Ubah Data Anda?';
    text = 'Silakan update data pendaftaran Anda.';
    icon = 'question';
  }

  Swal.fire({
    title: title,
    text: text,
    icon: icon,
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
      text: "Data akan dihapus secara permanen.",
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

  function confirmShow(url) {
    Swal.fire({
      title: 'Lihat Detail?',
      text: "Anda akan diarahkan ke halaman detail pendaftaran.",
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

  function confirmPrint(url) {
    Swal.fire({
      title: 'Cetak Formulir?',
      text: "Anda akan diarahkan ke halaman cetak formulir.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Cetak',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }
</script>
@endsection
