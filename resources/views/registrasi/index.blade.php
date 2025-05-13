@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Pengguna</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Data Pengguna</li>
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
            <div class="card-header bg-primary text-white">
              <h3 class="card-title">Daftar Data Pengguna</h3>
            </div>
          </div>
        </div>
      </div>

  <!-- Content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Notifikasi Sukses -->
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

      <div class="card">
        <div class="card-body">

          
           <div class="mb-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <!-- Search Input -->
           <div class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 100%;">
              <input type="text" id="search" placeholder="🔍 Cari pengguna..." 
                class="form-control shadow-sm rounded-pill me-2" style="max-width: 300px;">
          
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
                  @foreach (['admin', 'guru', 'siswa', 'calon_siswa'] as $role)
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
            </div>
              <!-- Button Tambah -->
              <a href="javascript:void(0)" onclick="confirmAdd('{{ route('registrasi.create') }}')" 
                class="btn btn-primary fw-bold shadow-sm rounded-pill px-4">
                <i class="fas fa-plus-circle me-1"></i> Tambah Pengguna
              </a>
            </div>

          <!-- Tabel Pengguna -->
          <div class="table-responsive">
            <table id="usersTable" class="table table-hover table-striped align-middle">
              <thead class="bg-primary text-white">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="userTableBody">
                @foreach($users as $index => $user)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                      @php
                        $roleColor = [
                          'admin' => 'badge-danger',
                          'guru' => 'badge-warning',
                          'siswa' => 'badge-primary',
                          'calon_siswa' => 'badge-success',
                          'Orang Tua' => 'badge-light',
                        ];
                        $color = $roleColor[strtolower($user->role_name)] ?? 'badge-dark';
                      @endphp
                      <span class="badge {{ $color }} text-uppercase shadow-sm">{{ $user->role_name }}</span>
                    </td>
                    <td>
                      <a href="javascript:void(0)" onclick="confirmView('{{ route('registrasi.show', $user->id) }}')" 
                        class="btn btn-info btn-sm rounded-circle shadow-sm me-1" 
                        data-bs-toggle="tooltip" title="Lihat">
                        <i class="fas fa-eye"></i>
                      </a>

                      <button class="btn btn-warning btn-sm rounded-circle shadow-sm me-1" 
                              onclick="confirmEdit('{{ route('registrasi.edit', $user->id) }}')" 
                              data-bs-toggle="tooltip" title="Edit">
                        <i class="fas fa-edit"></i>
                      </button>

                      <form action="{{ route('registrasi.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm rounded-circle shadow-sm" 
                                onclick="confirmDelete(this.form)" 
                                data-bs-toggle="tooltip" title="Hapus">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- Pagination Placeholder -->
          <div id="pagination" class="mt-4 d-flex justify-content-center"></div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- SweetAlert2 CDN -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>

<!-- Custom JavaScript -->
<script>
//Pagination
document.addEventListener("DOMContentLoaded", function () {
  const table = document.getElementById("usersTable");
  const searchInput = document.getElementById("search");
  const rows = table.getElementsByTagName("tr");
  const pagination = document.getElementById("pagination");
  let currentPage = 1;
  const rowsPerPage = 5;


  function showPage(page) {
    let visibleRows = [];
    const filter = searchInput.value.toLowerCase();

    for (let i = 1; i < rows.length; i++) {
      const text = rows[i].textContent.toLowerCase();
      const match = text.includes(filter);
      rows[i].style.display = match ? "" : "none";
      if (match) visibleRows.push(rows[i]);
    }

    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    visibleRows.forEach((row, index) => {
      row.style.display = (index >= start && index < end) ? "" : "none";
    });

    return visibleRows.length;
  }

  function updatePaginationUI(totalVisible) {
    const totalPages = Math.ceil(totalVisible / rowsPerPage);
    pagination.innerHTML = '';

    if (totalPages <= 1) return;

    const prevButton = document.createElement('button');
    prevButton.className = 'btn btn-sm btn-outline-primary';
    prevButton.textContent = '«';
    prevButton.disabled = currentPage === 1;
    prevButton.onclick = () => {
      if (currentPage > 1) {
        currentPage--;
        const visibleCount = showPage(currentPage);
        updatePaginationUI(visibleCount);
      }
    };

    const nextButton = document.createElement('button');
    nextButton.className = 'btn btn-sm btn-outline-primary';
    nextButton.textContent = '»';
    nextButton.disabled = currentPage === totalPages;
    nextButton.onclick = () => {
      if (currentPage < totalPages) {
        currentPage++;
        const visibleCount = showPage(currentPage);
        updatePaginationUI(visibleCount);
      }
    };

    const pageInfo = document.createElement('span');
    pageInfo.className = 'mx-2';
    pageInfo.textContent = `Halaman ${currentPage} dari ${totalPages}`;

    pagination.appendChild(prevButton);
    pagination.appendChild(pageInfo);
    pagination.appendChild(nextButton);
  }

  function refreshTable() {
    currentPage = 1;
    const visibleCount = showPage(currentPage);
    updatePaginationUI(visibleCount);
  }

  // Event saat search diketik
  searchInput.addEventListener("keyup", refreshTable);

  // Inisialisasi pertama kali
  refreshTable();
});


// SweetAlert untuk Tambah Pengguna
function confirmAdd(url) {
  Swal.fire({
    title: 'Anda ingin menambah pengguna baru?',
    text: 'Anda akan diarahkan ke halaman pendaftaran.',
    icon: 'info',
    showCancelButton: true,
    confirmButtonText: 'Lanjutkan',
    cancelButtonText: 'Batal',
  }).then(result => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}

// SweetAlert untuk Hapus Pengguna
function confirmDelete(form) {
  Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: 'Data ini tidak dapat dikembalikan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
  }).then(result => {
    if (result.isConfirmed) {
      form.submit();
    }
  });
}

// SweetAlert untuk Edit Pengguna
function confirmEdit(url) {
  Swal.fire({
    title: 'Edit Pengguna?',
    text: 'Anda akan diarahkan ke halaman edit.',
    icon: 'info',
    showCancelButton: true,
    confirmButtonText: 'Lanjutkan',
    cancelButtonText: 'Batal',
  }).then(result => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}

// SweetAlert untuk View Detail
function confirmView(url) {
  Swal.fire({
    title: 'Anda ingin melihat detail?',
    text: 'Anda akan diarahkan ke halaman detail.',
    icon: 'info',
    confirmButtonText: 'Lanjutkan',
  }).then(result => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}
</script>
@endsection
