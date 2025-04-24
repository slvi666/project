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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Kelas & Pelajaran</h3>
                <div class="card-tools">
                  <a href="{{ route('subjects.create') }}" class="btn btn-primary">Tambah Kelas & Pelajaran</a>
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

                <input type="text" id="search" placeholder="Cari Mata Pelajaran" class="form-control mb-3">

                <table id="subjectsTable" class="table table-bordered table-striped">
                  <thead class="bg-primary text-white">
                    <tr>
                      <th>No</th>
                      <th>Kelas</th>
                      <th>Mata Pelajaran</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($subjects as $index => $subject)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $subject->class_name }}</td>
                        <td>{{ $subject->subject_name }}</td>
                        <td>
                          <button type="button" class="btn btn-info" onclick="window.location.href='{{ route('subjects.show', $subject->id) }}'">Lihat</button>
                          <button type="button" class="btn btn-warning" onclick="confirmEdit('{{ route('subjects.edit', $subject->id) }}')">Edit</button>
                          <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(this.form)">Hapus</button>
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

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      let table = document.getElementById("subjectsTable");
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
  </script>
@endsection