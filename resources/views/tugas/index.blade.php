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
          <div class="card shadow-lg rounded">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
              <h3 class="card-title m-0">Daftar Tugas</h3>
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
                <input type="text" id="search" placeholder="🔍 Cari ..." class="form-control w-50 shadow-sm rounded-pill px-3">
                @if (auth()->user()->role_name === 'guru')
                <a href="javascript:void(0)" onclick="confirmAdd('{{ route('tugas.create') }}')" class="btn btn-primary text-light fw-bold shadow-sm rounded-pill px-4">
                  <i class="fas fa-plus-circle me-1"></i> Tambah Tugas
                </a>
                @endif
              </div>

              <div class="table-responsive">
                <table id="tugasTable" class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th>No</th>
                      <th>Judul</th>
                      <th>Siswa</th>
                      <th>Kelas</th>
                      <th>Guru</th>
                      <th>Mapel</th>
                      <th>Deadline</th>
                      <th>Status</th>
                      <th>Soal</th>
                      <th>Jawaban</th>
                      <th>Nilai</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tugas as $index => $item)
                    <tr>
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td>{{ $item->judul_tugas }}</td>
                      <td>{{ $item->siswa->user->name ?? '-' }}</td>
                      <td>{{ $item->subject->class_name }}</td>
                      <td>
                        <span class="badge bg-info text-dark">{{ $item->guru->nama_guru }}</span>
                      </td>
                      <td>{{ $item->subject->subject_name }}</td>
                      <td>{{ \Carbon\Carbon::parse($item->deadline)->format('d/m/Y') }}</td>
                      <td>
                        <span class="badge 
                            @if($item->status == 'sudah_dikumpulkan')
                                bg-success text-white
                            @elseif($item->status == 'belum_dikumpulkan')
                            @else
                                bg-warning text-dark
                            @endif
                        ">
                            @if($item->status == 'sudah_dikumpulkan')
                                <i class="fa fa-check-circle"></i> Terkumpul
                            @elseif($item->status == 'belum_dikumpulkan')
                            @else
                                <i class="fa fa-question-circle"></i> Belum Terkumpul
                            @endif
                        </span>
                    </td>
                    
                      <td class="text-center">
                        @if($item->file_soal)
                          <a href="{{ route('tugas.download.soal', $item->id) }}" class="btn btn-outline-info btn-sm rounded-pill" title="Download Soal">
                              <i class="fas fa-file-alt"></i>
                          </a>
                        @else
                          <span class="badge bg-secondary">Tidak Ada</span>
                          @endif
                          </td>
                          <td class="text-center">
                        @if($item->file_jawaban)
                          <a href="{{ route('tugas.download.jawaban', $item->id) }}" class="btn btn-outline-success btn-sm rounded-pill" title="Download Jawaban">
                              <i class="fas fa-file-upload"></i>
                          </a>
                        @else
                          <span class="badge bg-secondary">Tidak Ada</span>
                        @endif

                      </td>
                      <td class="text-center">
                        @if($item->nilai_tugas !== null)
                        {{ $item->nilai_tugas }}
                        @else
                        <span class="text-muted">Belum dinilai</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <a href="javascript:void(0);" onclick="confirmEdit('{{ route('tugas.edit', $item->id) }}')" class="btn btn-warning btn-sm rounded-pill me-1 shadow-sm">
                          <i class="fas fa-edit"></i>
                        </a>
                         {{-- Tambahkan tombol Show --}}
                        <a href="javascript:void(0);" onclick="confirmShow('{{ route('tugas.show', $item->id) }}')" class="btn btn-info btn-sm rounded-pill me-1 shadow-sm text-white">
                          <i class="fas fa-eye"></i>
                        </a>
                        @if (auth()->user()->role_name === 'guru')
                        <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)">
                            <i class="fas fa-trash-alt"></i>
                          </button>
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

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.min.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("tugasTable");
    const searchInput = document.getElementById("search");
    const rows = table.getElementsByTagName("tr");
    const pagination = document.getElementById("pagination");
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
      title: 'Tambah Tugas Baru?',
      text: "Anda akan diarahkan ke halaman tambah tugas.",
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
      title: 'Edit Tugas?',
      text: "Anda akan diarahkan ke halaman edit tugas.",
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
      title: 'Yakin ingin hapus?',
      text: "Tugas ini akan dihapus secara permanen.",
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

  function confirmShow(url) {
  Swal.fire({
    title: 'Lihat Detail Tugas?',
    text: "Anda akan diarahkan ke halaman detail tugas.",
    icon: 'info',
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
