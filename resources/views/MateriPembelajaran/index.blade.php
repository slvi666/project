@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Daftar Materi Pembelajaran</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Materi</li>
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
                <h3 class="card-title">Daftar Materi Pembelajaran</h3>
                @if (auth()->user()->role_name === 'guru' || auth()->user()->role_name === 'Admin')
                <a href="{{ route('materi.create') }}" class="btn btn-primary btn-sm float-right">
                  <i class="fas fa-plus"></i> Tambah Materi
                </a>
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

                <input type="text" id="search" placeholder="Cari Materi" class="form-control mb-3">

                <div class="table-responsive">
                  <table id="materiTable" class="table table-bordered table-striped">
                    <thead class="bg-primary text-white">
                      <tr>
                        <th>No</th>
                        <th>Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Deskripsi</th>
                        <th>File</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($materi as $index => $m)
                        <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $m->guru->name ?? 'Tidak ada data' }}</td>
<td>{{ $m->subject->subject_name ?? 'Tidak ada data' }}</td>
<td>{{ $m->subject->class_name ?? 'Tidak ada data' }}</td>

                          <td>{{ $m->deskripsi }}</td>
                          <td><a href="{{ asset('storage/' . $m->file) }}" target="_blank">Lihat PDF</a></td>
                          <td>
                            <a href="{{ route('materi.show', $m->id) }}" class="btn btn-info btn-sm">Lihat</a>
                            @if (auth()->user()->role_name === 'guru' || auth()->user()->role_name === 'Admin')
                              <a href="javascript:void(0);" onclick="confirmEdit('{{ route('materi.edit', $m->id) }}')" class="btn btn-warning btn-sm">Edit</a>
                              <form onsubmit="event.preventDefault(); confirmDelete(this);" action="{{ route('materi.destroy', $m->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      let table = document.getElementById("materiTable");
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

    function confirmEdit(url) {
      Swal.fire({
        title: 'Edit Materi?',
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
  </script>
@endsection
