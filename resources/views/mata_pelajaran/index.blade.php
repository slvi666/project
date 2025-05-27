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

          <!-- Search + Reset + Add Button -->
          <div class="row mb-3 align-items-center">
            <div class="col-md-9 d-flex gap-2">
              <input type="text" id="search" placeholder="Cari Mata Pelajaran" class="form-control rounded-pill">
              <button id="resetFilters" class="btn btn-info btn-sm rounded-pill">
                <i class="fas fa-undo me-2"></i> Reset
              </button>
            </div>
            @if (auth()->user()->role_name === 'Admin')
            <div class="col-md-3 text-end mt-2 mt-md-0">
              <a href="#" class="btn btn-primary btn-sm rounded-pill"
                onclick="confirmNavigate('{{ route('mata-pelajaran.create') }}', 'Tambah Mata Pelajaran?')">
                <i class="fas fa-plus-circle me-2"></i> Tambah Mata Pelajaran
              </a>
            </div>
            @endif
          </div>

          <!-- Table Grouped By Kelas -->
          @php
            $groupedData = $data->groupBy('subject.class_name');
            $no = 1;
          @endphp

          @foreach($groupedData as $className => $items)
          <div class="mb-4">
            <h5 class="fw-bold text-primary">Kelas: {{ $className }}</h5>

            <div class="table-responsive">
              <table class="table table-bordered table-striped mapelTable">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>No</th>
                    <th>Nama Mapel</th>
                    <th>Guru</th>
                    <th>Hari</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($items as $item)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->subject->subject_name }}</td>
                    <td class="text-center">
                      @if($item->guru)
                        <span class="badge bg-success">{{ $item->guru->name }}</span>
                      @else
                        <span class="badge bg-secondary">-</span>
                      @endif
                    </td>
                    <td>{{ $item->hari }}</td>
                    <td>{{ substr($item->waktu_mulai, 0, 5) }} - {{ substr($item->waktu_berakhir, 0, 5) }}</td>
                    <td>
                      @if (auth()->user()->role_name === 'Admin')
                        <a href="#" class="btn btn-warning btn-sm rounded-pill"
                          onclick="confirmNavigate('{{ route('mata-pelajaran.edit', $item->id) }}', 'Edit data ini?')">
                          <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm mt-1 rounded-pill" onclick="hapusData({{ $item->id }})">
                          <i class="fas fa-trash-alt me-1"></i> Hapus
                        </button>
                        <form id="delete-form-{{ $item->id }}" action="{{ route('mata-pelajaran.destroy', $item->id) }}" method="POST" style="display: none;">
                          @csrf
                          @method('DELETE')
                        </form>
                      @endif

                      @if (auth()->user()->role_name === 'guru')
                        <button type="button" class="btn btn-primary btn-sm mt-1 rounded-pill" onclick="konfirmasiAbsensi('{{ route('absensi.create', $item->id) }}')">
                          Input Absensi
                        </button>
                      @endif

                      <a href="#" class="btn btn-success btn-sm mt-1 rounded-pill"
                        onclick="confirmNavigate('{{ route('mata-pelajaran.show', $item->id) }}', 'Lihat detail mata pelajaran ini?')">
                        <i class="fas fa-eye me-1"></i> Lihat Detail
                      </a>

                      <a href="#" class="btn btn-info btn-sm mt-1 rounded-pill"
                        onclick="confirmNavigate('{{ route('absensi.index', $item->id) }}', 'Lihat absensi kelas ini?')">
                        <i class="fas fa-eye me-1"></i> Lihat Absensi
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @endforeach

        </div>
      </div>
    </div>
  </section>
</div>

<script>
  function hapusData(id) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: "Data yang dihapus tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('delete-form-' + id).submit();
      }
    });
  }

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

  function konfirmasiAbsensi(url) {
    Swal.fire({
      title: 'Input Absensi?',
      text: "Anda akan masuk ke halaman input absensi!",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Lanjut',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    searchInput.addEventListener("keyup", function () {
      const keyword = searchInput.value.toLowerCase();
      document.querySelectorAll(".mapelTable tbody tr").forEach(function (row) {
        row.style.display = row.textContent.toLowerCase().includes(keyword) ? "" : "none";
      });
    });

    document.getElementById("resetFilters").addEventListener("click", function () {
      searchInput.value = "";
      document.querySelectorAll(".mapelTable tbody tr").forEach(function (row) {
        row.style.display = "";
      });
    });
  });
</script>
@endsection
