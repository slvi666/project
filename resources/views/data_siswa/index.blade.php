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
                @if(auth()->user()->role_name === 'Admin')
                  <div class="card-tools">
                    <a href="{{ route('data_siswa.create') }}" class="btn btn-primary">Tambah Siswa</a>
                  </div>
                @endif
              </div>
              <div class="card-body">
                @if (session('success'))
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

                <input type="text" id="search" placeholder="Cari Siswa" class="form-control mb-3">

                <table id="studentsTable" class="table table-bordered table-striped">
                  <thead class="bg-primary text-white">
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>NIS</th>
                      <th>Kelas</th>
                      <th>Alamat</th>
                      @if(auth()->user()->role_name === 'Admin')
                        <th>Aksi</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($dataSiswa as $index => $siswa)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $siswa->user->name }}</td>
                        <td>{{ $siswa->user->email }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->kelas }}</td>
                        <td>{{ $siswa->alamat }}</td>
                        @if(auth()->user()->role_name === 'Admin')
                          <td>
                            <button type="button" class="btn btn-warning btn-sm" onclick="confirmEdit('{{ route('data_siswa.edit', $siswa->id) }}')">Edit</button>
                            <form action="{{ route('data_siswa.destroy', $siswa->id) }}" method="POST" style="display:inline;">
                              @csrf
                              @method('DELETE')
                              <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this.form)">Hapus</button>
                            </form>
                          </td>
                        @endif
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

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      let table = document.getElementById("studentsTable");
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

    function confirmDelete(form) {
      Swal.fire({
        title: 'Anda yakin?',
        text: "Data siswa ini akan dihapus!",
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
        title: 'Edit Siswa',
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
  </script>
@endsection
