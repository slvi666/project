@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="m-0">Daftar Pengguna</h1>
        
        <a href="javascript:void(0)" onclick="confirmAdd('{{ route('registrasi.create') }}')" class="btn btn-success">
          <i class="fas fa-user-plus"></i> Tambah Pengguna
        </a>
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

          <!-- Search & Filter -->
          <div class="mb-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <input type="text" id="search" placeholder="🔍 Cari pengguna..." class="form-control w-50 shadow-sm">

            <form method="GET" action="{{ route('registrasi.index') }}" class="d-flex align-items-center gap-2">
              <label for="role" class="me-2 mb-0">Filter Pengguna:</label>
              <select name="role" id="role" class="form-select shadow-sm" onchange="this.form.submit()">
                <option value="">Semua</option>
                @foreach (['admin', 'guru', 'siswa', 'calon_siswa', 'Orang Tua'] as $role)
                  <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $role)) }}
                  </option>
                @endforeach
              </select>
              @if(request('role'))
                <a href="{{ route('registrasi.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
              @endif
            </form>
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
                      <a href="javascript:void(0)" onclick="confirmView('{{ route('registrasi.show', $user->id) }}')" class="btn btn-info btn-sm rounded-pill shadow-sm me-1">
                        <i class="fas fa-eye"></i> Lihat
                      </a>

                      <button class="btn btn-warning btn-sm rounded-pill shadow-sm me-1"
                              onclick="confirmEdit('{{ route('registrasi.edit', $user->id) }}')">
                        <i class="fas fa-edit"></i> Edit
                      </button>

                      <form action="{{ route('registrasi.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)">
                          <i class="fas fa-trash"></i> Hapus
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
  
  // Filter pencarian berdasarkan keyword
  document.getElementById('search').addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    document.querySelectorAll('#usersTable tbody tr').forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(filter) ? '' : 'none';
    });
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
