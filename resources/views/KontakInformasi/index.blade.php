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
                <h3 class="card-title">Daftar Kontak Informasi</h3>
                <button class="btn btn-primary float-right" onclick="confirmAdd()">+ Tambah Kontak</button>
              </div>
              <div class="card-body">

                @if(session('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif

                <input type="text" id="search" placeholder="Cari Kontak" class="form-control mb-3">

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
                    @foreach ($kontaks as $index => $kontak)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kontak->nama_identitas }}</td>
                        <td>{{ $kontak->email }}</td>
                        <td>{{ $kontak->no_telpon }}</td>
                        <td>{{ $kontak->no_wa }}</td>
                        <td>{{ $kontak->instagram }}</td>
                        <td>{{ $kontak->fb }}</td>
                        <td>{{ $kontak->alamat }}</td>
                        <td>
                          <button class="btn btn-warning btn-sm" onclick="confirmEdit({{ $kontak->id }})">Edit</button>
                          <form action="{{ route('kontak-informasi.destroy', $kontak->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $kontak->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $kontak->id }})">Hapus</button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>

                <div id="pagination" class="mt-3 text-center"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- SweetAlert2 Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      let table = document.getElementById("kontakTable");
      let searchInput = document.getElementById("search");
      let rows = table.getElementsByTagName("tr");
      let currentPage = 1;
      let rowsPerPage = 5;
      let pagination = document.getElementById("pagination");

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
          btn.onclick = function () {
            currentPage = i;
            showPage(i);
          };
          pagination.appendChild(btn);
        }
      }

      searchInput.addEventListener("keyup", function () {
        let filter = searchInput.value.toLowerCase();
        for (let i = 1; i < rows.length; i++) {
          let text = rows[i].textContent.toLowerCase();
          rows[i].style.display = text.includes(filter) ? "table-row" : "none";
        }
      });

      showPage(1);
      setupPagination();
    });

    // SweetAlert2 for Confirming Deletion
    function confirmDelete(id) {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-form-' + id).submit();
        }
      });
    }

    // SweetAlert2 for Confirming Edit
    function confirmEdit(id) {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda akan mengedit data kontak ini.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, edit!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "{{ route('kontak-informasi.edit', ':id') }}".replace(':id', id);
        }
      });
    }

    // SweetAlert2 for Confirming Add New Kontak
    function confirmAdd() {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda akan menambah data kontak baru.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, tambah!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "{{ route('kontak-informasi.create') }}";
        }
      });
    }
  </script>

@endsection
