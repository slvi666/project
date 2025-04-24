@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Kontak Informasi</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Kontak</li>
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
              <h3 class="card-title">Kontak Informasi</h3>
              <div class="card-tools">
                <a href="javascript:void(0)" onclick="confirmAdd('{{ route('kontak-informasi.create') }}')" class="btn btn-success shadow-sm">
                  <i class="fas fa-plus-circle"></i> Tambah Kontak
                </a>
              </div>
            </div>

            <div class="card-body">
              @if(session('success'))
                <script>
                  Swal.fire({
                    title: 'Sukses!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                  }).then(() => {
                    window.location.reload();
                  });
                </script>
              @endif

              <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" id="searchInput" placeholder="🔍 Cari Kontak..." class="form-control w-50 shadow-sm">
              </div>

              <div class="table-responsive">
                <table id="kontakTable" class="table table-bordered table-striped">
                  <thead class="bg-primary text-white">
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>No Telpon</th>
                      <th>No WA</th>
                      <th>Instagram</th>
                      <th>FB</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($kontaks as $kontak)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kontak->nama_identitas }}</td>
                        <td>{{ $kontak->email }}</td>
                        <td>{{ $kontak->no_telpon }}</td>
                        <td>{{ $kontak->no_wa }}</td>
                        <td>{{ $kontak->instagram }}</td>
                        <td>{{ $kontak->fb }}</td>
                        <td>{{ $kontak->alamat }}</td>
                        <td>
                          <a href="javascript:void(0)" onclick="confirmDetail('{{ route('kontak-informasi.show', $kontak->id) }}')" class="btn btn-info btn-sm rounded-pill shadow-sm me-1">
                            <i class="fas fa-eye"></i> Lihat
                          </a>                      
                          <a href="javascript:void(0)" onclick="confirmEdit('{{ route('kontak-informasi.edit', $kontak->id) }}')" class="btn btn-warning btn-sm rounded-pill shadow-sm me-1">
                            <i class="fas fa-edit"></i> Edit
                          </a>
                          <form action="{{ route('kontak-informasi.destroy', $kontak->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)">
                              <i class="fas fa-trash"></i> Hapus
                            </button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="9" class="text-center">Belum ada kontak</td>
                      </tr>
                    @endforelse
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

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("kontakTable");
    const searchInput = document.getElementById("searchInput");
    const rows = table.getElementsByTagName("tr");
    const pagination = document.getElementById("paginationContainer");
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

  function confirmAdd(url) {
    Swal.fire({
      title: 'Tambah Kontak Baru?',
      text: "Anda akan diarahkan ke halaman tambah kontak.",
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
      title: 'Edit Kontak?',
      text: "Anda akan diarahkan ke halaman edit kontak.",
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
      title: 'Hapus Kontak ini?',
      text: "Data yang dihapus tidak dapat dikembalikan.",
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

  function confirmDetail(url) {
  Swal.fire({
    title: 'Lihat Detail Kontak?',
    text: "Anda akan diarahkan ke halaman detail kontak.",
    icon: 'question',
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
