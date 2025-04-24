@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary">Daftar Jadwal Pelajaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Daftar Jadwal Pelajaran</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-lg rounded-4">
        <div class="card-header bg-gradient-info text-white rounded-top">
          <h3 class="card-title">Daftar Jadwal Pelajaran</h3>
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

          <!-- Search + Add Button -->
          <div class="row mb-3 d-flex justify-content-between align-items-center">
            <div class="col-md-6">
              <input type="text" id="search" placeholder="Cari Mata Pelajaran" class="form-control rounded-pill">
            </div>
            @if (auth()->user()->role_name === 'Admin')
            <div class="col-md-3 text-md-end mt-2 mt-md-0">
              <a href="#" class="btn btn-primary btn-sm rounded-pill"
                onclick="confirmNavigate('{{ route('mata-pelajaran.create') }}', 'Tambah Mata Pelajaran?')">
                <i class="fas fa-plus-circle me-2"></i> Tambah Mata Pelajaran
              </a>
            </div>
            @endif
          </div>

          <!-- Filter Dropdowns -->
          <div class="row mb-3">
            <div class="col-md-4">
              <select id="filterMapel" class="form-control rounded-pill">
                <option value="">Semua Mapel</option>
                @foreach($data->unique('subject.subject_name') as $item)
                  <option value="{{ $item->subject->subject_name }}">{{ $item->subject->subject_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <select id="filterKelas" class="form-control rounded-pill">
                <option value="">Semua Kelas</option>
                @foreach($data->unique('subject.class_name') as $item)
                  <option value="{{ $item->subject->class_name }}">{{ $item->subject->class_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <select id="filterGuru" class="form-control rounded-pill">
                <option value="">Semua Guru</option>
                @foreach($data->unique('guru.name') as $item)
                  <option value="{{ $item->guru->name }}">{{ $item->guru->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Table -->
          <table id="mapelTable" class="table table-bordered table-striped">
            <thead class="bg-primary text-white">
              <tr>
                <th>No</th>
                <th>Nama Mapel</th>
                <th>Kelas</th>
                <th>Guru</th>
                <th>Hari</th>
                <th>Waktu</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $index => $item)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->subject->subject_name }}</td>
                <td>{{ $item->subject->class_name }}</td>
                <td>{{ $item->guru->name }}</td>
                <td>{{ $item->hari }}</td>
                <td>{{ $item->waktu_mulai }} - {{ $item->waktu_berakhir }}</td>
                <td>
                  @if (auth()->user()->role_name === 'Admin')
                  <a href="#" class="btn btn-warning btn-sm rounded-pill"
                    onclick="confirmNavigate('{{ route('mata-pelajaran.edit', $item->id) }}', 'Edit data ini?')">
                    <i class="fas fa-edit me-1"></i> Edit
                  </a>
                  @endif
                  @if (auth()->user()->role_name === 'guru')
                    <a href="{{ route('absensi.create', $item->id) }}" class="btn btn-primary btn-sm mt-1 rounded-pill">Input Absensi</a>
                  @endif
                  <a href="#" class="btn btn-info btn-sm mt-1 rounded-pill"
                    onclick="confirmNavigate('{{ route('absensi.index', $item->id) }}', 'Lihat absensi kelas ini?')">
                    <i class="fas fa-eye me-1"></i> Lihat Absensi
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <div id="pagination" class="mt-3 text-center"></div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    let table = document.getElementById("mapelTable");
    let searchInput = document.getElementById("search");
    let rows = table.getElementsByTagName("tr");
    let currentPage = 1;
    let rowsPerPage = 5;
    let pagination = document.getElementById("pagination");

    function showPage(page) {
      let start = (page - 1) * rowsPerPage + 1;
      let end = start + rowsPerPage;
      let visibleCount = 0;
      for (let i = 1; i < rows.length; i++) {
        if (rows[i].style.display !== "none") {
          visibleCount++;
          rows[i].style.display = (visibleCount > (start - 1) && visibleCount <= (end - 1)) ? "table-row" : "none";
        }
      }
    }

    function setupPagination() {
      pagination.innerHTML = "";
      let visibleRows = Array.from(rows).slice(1).filter(row => row.style.display !== "none");
      let pageCount = Math.ceil(visibleRows.length / rowsPerPage);
      for (let i = 1; i <= pageCount; i++) {
        let btn = document.createElement("button");
        btn.innerText = i;
        btn.className = "btn btn-sm btn-secondary mx-1 rounded-pill";
        btn.onclick = function () { currentPage = i; showPage(i); };
        pagination.appendChild(btn);
      }
    }

    function filterAll() {
      let mapel = document.getElementById("filterMapel").value.toLowerCase();
      let kelas = document.getElementById("filterKelas").value.toLowerCase();
      let guru = document.getElementById("filterGuru").value.toLowerCase();
      let search = searchInput.value.toLowerCase();

      for (let i = 1; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName("td");
        let matchMapel = !mapel || cells[1].textContent.toLowerCase().includes(mapel);
        let matchKelas = !kelas || cells[2].textContent.toLowerCase().includes(kelas);
        let matchGuru = !guru || cells[3].textContent.toLowerCase().includes(guru);
        let matchSearch = !search || rows[i].textContent.toLowerCase().includes(search);

        if (matchMapel && matchKelas && matchGuru && matchSearch) {
          rows[i].style.display = "";
        } else {
          rows[i].style.display = "none";
        }
      }

      showPage(1);
      setupPagination();
    }

    searchInput.addEventListener("keyup", filterAll);
    document.getElementById("filterMapel").addEventListener("change", filterAll);
    document.getElementById("filterKelas").addEventListener("change", filterAll);
    document.getElementById("filterGuru").addEventListener("change", filterAll);

    filterAll();
  });

  // function confirmDelete(form) {
  //   Swal.fire({
  //     title: 'Yakin ingin menghapus?',
  //     text: "Data ini akan hilang secara permanen!",
  //     icon: 'warning',
  //     showCancelButton: true,
  //     confirmButtonText: 'Ya, hapus!',
  //     cancelButtonText: 'Batal'
  //   }).then((result) => {
  //     if (result.isConfirmed) {
  //       form.submit();
  //     }
  //   });
  // }

  function confirmNavigate(url, message = 'Yakin ingin melanjutkan?') {
    Swal.fire({
      title: 'Konfirmasi',
      text: message,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }
</script>
</script>
@endsection
