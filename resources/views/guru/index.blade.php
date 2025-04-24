@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Daftar Guru</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Daftar Guru</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Guru</h3>
                <div class="card-tools">
                  @if(auth()->user()->role_name === 'Admin')
                    <a href="{{ route('guru.create') }}" class="btn btn-primary btn-sm">Tambah Guru Baru</a>
                  @endif
                </div>
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

                <input type="text" id="search" placeholder="Cari Guru" class="form-control mb-3">

                <div class="table-responsive">
                  <table id="guruTable" class="table table-bordered table-striped">
                    <thead class="bg-primary text-white">
                      <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        @if(auth()->user()->role_name === 'Admin')
                          <th>Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($guru as $index => $g)
                        <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $g->nip }}</td>
                          <td>{{ $g->nama_guru }}</td>
                          <td>{{ $g->alamat }}</td>
                          <td>{{ $g->jenis_kelamin }}</td>
                          <td>{{ $g->telepon }}</td>
                          @if(auth()->user()->role_name === 'Admin')
                            <td>
                              <button type="button" class="btn btn-info btn-sm" onclick="confirmView('{{ route('guru.show', $g->id) }}')">Detail</button>
                              <button type="button" class="btn btn-warning btn-sm" onclick="confirmEdit('{{ route('guru.edit', $g->id) }}')">Edit</button>
                              <form action="{{ route('guru.destroy', $g->id) }}" method="POST" style="display:inline;">
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
                </div>

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
      let table = document.getElementById("guruTable");
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
        title: 'Anda ingin melihat detail?',
        text: "Anda akan diarahkan ke halaman detail.",
        icon: 'info',
        confirmButtonText: 'Lanjutkan'
      }).then((result) => {
        if (result.isConfirmed) {
          document.location.href = url;
        }
      });
    }
  </script>
@endsection
