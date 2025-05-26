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
        <div class="col-lg-12">
          <div class="card shadow-lg rounded">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
              <h3 class="card-title m-0">Daftar Materi Pembelajaran</h3>
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

              {{-- Search --}}
              <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" id="search" placeholder="🔍 Cari Materi..." class="form-control w-50 shadow-sm rounded-pill px-3">
                @if (auth()->user()->role_name === 'guru' || auth()->user()->role_name === 'Admin')
                <a href="javascript:void(0)" onclick="confirmAdd('{{ route('materi.create') }}')" 
                  class="btn btn-primary fw-bold shadow-sm rounded-pill px-4 ms-3">
                  <i class="fas fa-plus-circle me-1"></i> Tambah Materi
                </a>
                @endif
              </div>

              {{-- <div class="d-flex flex-wrap justify-content-start align-items-center gap-3 mb-3">
                <!-- Filter Dropdown -->
                <form method="GET" action="{{ route('registrasi.index') }}" class="d-flex align-items-center gap-2">
                  <div class="input-group shadow-sm rounded-pill" style="overflow: hidden; max-width: 300px;">
              
                    <!-- Label Filter -->
                    <span class="input-group-text text-white fw-semibold" 
                          style="background: linear-gradient(90deg, #0d6efd, #3f8efc); border: none;">
                      <i class="fas fa-filter me-1"></i> Filter
                    </span>
              
                    <!-- Dropdown Role -->
                    <select name="role" id="role" class="form-select border-0" onchange="this.form.submit()" style="border-left: 1px solid #ddd;">
                      <option value="">Semua</option>
                      @foreach (['admin', 'guru', 'siswa', 'calon_siswa', 'Orang Tua'] as $role)
                        <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                          {{ ucfirst(str_replace('_', ' ', $role)) }}
                        </option>
                      @endforeach
                    </select>
                  </div>
              
                  <!-- Reset Button -->
                  @if(request('role'))
                    <a href="{{ route('registrasi.index') }}" 
                      class="btn shadow-sm d-flex align-items-center justify-content-center rounded-circle"
                      style="width: 44px; height: 44px; background-color: #faed3b; color: #575848; font-size: 1.2rem;"
                      data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Filter">
                      <i class="fas fa-redo-alt"></i>
                    </a>
                  @endif
                </form>
              </div> --}}

              <div class="d-flex flex-wrap justify-content-start align-items-center gap-3 mb-3">
                <!-- Filter Dropdown Kelas Saja -->
                <form method="GET" action="{{ route('materi.index') }}" class="d-flex align-items-center gap-2">
                  <div class="input-group shadow-sm rounded-pill" style="overflow: hidden; max-width: 300px;">
                    <span class="input-group-text text-white fw-semibold" 
                          style="background: linear-gradient(90deg, #0d6efd, #3f8efc); border: none;">
                      <i class="fas fa-school me-1"></i> Kelas
                    </span>
                    <select name="kelas" id="kelas" class="form-select border-0" onchange="this.form.submit()">
                      <option value="">Semua Kelas</option>
                      @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>
                          {{ $kelas }}
                        </option>
                      @endforeach
                    </select>
                  </div>
              
                  <!-- Reset Button (muncul hanya ketika filter aktif) -->
                  @if(request('kelas'))
                    <a href="{{ route('materi.index') }}" 
                       class="btn shadow-sm d-flex align-items-center justify-content-center rounded-circle"
                       style="width: 44px; height: 44px; background-color: #faed3b; color: #575848;"
                       title="Reset Filter">
                      <i class="fas fa-redo-alt"></i>
                    </a>
                  @endif
                </form>
              </div>

              <div class="table-responsive">
                <table id="materiTable" class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th style="width: 5%;">No</th>
                      <th>Guru</th>
                      <th>Mata Pelajaran</th>
                      <th>Kelas</th>
                      <th>Deskripsi</th>
                      {{-- <th>File</th> --}}
                      <th style="width: 20%;">Aksi</th>
                    </tr>
                  </thead>
                <tbody>
                  @if($materi->isEmpty())
                    <tr>
                      <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle fa-lg me-2"></i> Data materi masih kosong.
                      </td>
                    </tr>
                  @else
                    @foreach($materi as $index => $m)
                      @if(auth()->user()->role_name === 'guru' && $m->guru_id !== auth()->user()->id)

                        @continue
                      @endif

                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">
                          @if($m->guru)
                            <span class="badge bg-success">{{ $m->guru->name }}</span>
                          @else
                            <span class="badge bg-secondary">-</span>
                          @endif
                        </td>
                        <td>{{ $m->subject->subject_name ?? '-' }}</td>
                        <td>{{ $m->subject->class_name ?? '-' }}</td>
                        <td class="text-truncate" style="max-width: 250px;">{{ Str::limit($m->deskripsi, 80, '...') }}</td>
                        
                        <td class="text-center">
                          <a href="javascript:void(0);" onclick="confirmShow('{{ route('materi.show', $m->id) }}')" class="btn btn-info btn-sm rounded-pill me-1 shadow-sm">
                            <i class="fas fa-eye"></i>
                          </a>
                          @if (auth()->user()->role_name === 'guru' || auth()->user()->role_name === 'Admin')
                            <a href="javascript:void(0);" onclick="confirmEdit('{{ route('materi.edit', $m->id) }}')" class="btn btn-warning btn-sm rounded-pill me-1 shadow-sm">
                              <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('materi.destroy', $m->id) }}" method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                              <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  @endif
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

<!-- Script & Pagination -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("materiTable");
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
      title: 'Tambah Materi Baru?',
      text: "Anda akan diarahkan ke halaman tambah materi.",
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
      title: 'Edit Materi?',
      text: "Anda akan diarahkan ke halaman edit materi.",
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

  function confirmShow(url) {
  Swal.fire({
    title: 'Lihat Detail Materi?',
    text: "Anda akan diarahkan ke halaman detail materi.",
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
