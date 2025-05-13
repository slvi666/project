@extends('adminlte.layouts.app')

@section('content')

<div class="content-wrapper">

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Pengumuman</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Pengumuman</li>
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
              <h3 class="card-title m-0">Daftar Pengumuman</h3>
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
                <input type="text" id="searchInput" placeholder="🔍 Cari pengumuman..." class="form-control w-50 shadow-sm rounded-pill px-3">
              @if (auth()->user()->role_name === 'Admin')
              <a href="javascript:void(0)" onclick="confirmAdd('{{ route('pengumuman.create') }}')" 
                class="btn btn-primary fw-bold shadow-sm rounded-pill px-4">
                <i class="fas fa-plus-circle me-1"></i> Tambah Pengumuman
              </a>
              @endif
              </div>

              <div class="table-responsive">
                <table id="announcementTable" class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th style="width: 5%;">No</th>
                      <th>Judul</th>
                      <th>Status</th>
                      <th>Tanggal Mulai</th>
                      <th>Tanggal Berakhir</th>
                      <th style="width: 25%;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($pengumuman as $index => $item)
                    <tr>
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td>{{ $item->judul_pengumuman }}</td>
                      <td class="text-center">
                        <span class="badge {{ $item->status === 'aktif' ? 'bg-success' : 'bg-danger' }}">
                          {{ ucfirst($item->status) }}
                        </span>
                      </td>
                      <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</td>
                      <td>{{ \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d-m-Y') }}</td>

                      <td class="text-center">
                        <a href="javascript:void(0)" onclick="confirmView('{{ route('pengumuman.show', $item->id) }}')" class="btn btn-info btn-sm rounded-pill shadow-sm me-1" title="Lihat Detail">
                          <i class="fas fa-eye"></i> <!-- Ikon mata untuk "Lihat Detail" -->
                        </a>
                        <button class="btn btn-warning btn-sm rounded-pill shadow-sm me-1" onclick="confirmEdit('{{ route('pengumuman.edit', $item->id) }}')" title="Edit">
                          <i class="fas fa-edit"></i> <!-- Ikon pensil untuk "Edit" -->
                        </button>
                        <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)" title="Hapus">
                            <i class="fas fa-trash"></i> <!-- Ikon tempat sampah untuk "Hapus" -->
                          </button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <div id="paginationContainer" class="mt-3 text-center"></div>
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
  document.addEventListener("DOMContentLoaded", function() {
    let table = document.getElementById("announcementTable");
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
      title: 'Tambah Pengumuman Baru?',
      text: "Anda akan diarahkan ke halaman tambah pengumuman.",
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
      title: 'Anda yakin ingin mengedit?',
      text: "Anda akan diarahkan ke halaman edit.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Ya, lanjutkan!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }

  function confirmView(url) {
    Swal.fire({
      title: 'Lihat Detail Pengumuman?',
      text: "Anda akan diarahkan ke halaman detail.",
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
      title: 'Anda yakin?',
      text: "Pengumuman ini akan dihapus!",
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
