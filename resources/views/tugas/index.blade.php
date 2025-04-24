@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Daftar Tugas Siswa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Tugas</li>
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
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Tugas</h3>
                @if (auth()->user()->role_name === 'guru')
                <div class="card-tools">
                  <a href="{{ route('tugas.create') }}" class="btn btn-primary">Tambah Tugas</a>
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
                    });
                  </script>
                @endif

                <div class="mb-3">
                  <input type="text" id="search" placeholder="Cari Tugas" class="form-control">
                </div>

                <div class="table-responsive">
                  <table id="tugasTable" class="table table-bordered table-striped">
                    <thead class="bg-primary text-white">
                      <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Siswa</th>
                        <th>Guru</th>
                        <th>Mapel</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>File Soal</th>
                        <th>File Jawaban</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($tugas as $index => $item)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->judul_tugas }}</td>
                        <td>{{ $item->siswa->user->name ?? '-' }}</td>
                        <td>{{ $item->guru->nama_guru }}</td>
                        <td>{{ $item->subject->subject_name }}</td>
                        <td>{{ $item->deadline }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>
                          @if($item->file_soal)
                            <a href="{{ route('tugas.download.soal', $item->id) }}" class="btn btn-sm btn-info">Download</a>
                          @else
                            -
                          @endif
                        </td>
                        <td>
                          @if($item->file_jawaban)
                            <a href="{{ route('tugas.download.jawaban', $item->id) }}" class="btn btn-sm btn-success">Download</a>
                          @else
                            -
                          @endif
                        </td>
                        <td>
                          @if($item->nilai_tugas !== null)
                            {{ $item->nilai_tugas }}
                          @else
                            <span class="text-muted">Belum dinilai</span>
                          @endif
                        </td>
                        <td>
                          <a href="{{ route('tugas.edit', $item->id) }}" class="btn btn-sm btn-warning mb-1">Jawab</a>
                          @if (auth()->user()->role_name === 'guru')
                          <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this.form)">Hapus</button>
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
      let table = document.getElementById("tugasTable");
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
        text: "Tugas ini akan dihapus!",
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
