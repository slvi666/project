@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="m-0">Daftar Pengguna</h1>
        <!-- Tombol Tambah Pengguna dengan SweetAlert -->
        <a href="javascript:void(0)" onclick="confirmAdd('{{ route('registrasi.create') }}')" class="btn btn-success">
          <i class="fas fa-user-plus"></i> Tambah Pengguna
        </a>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
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
          <div class="mb-3 d-flex justify-content-between align-items-center">
            <input type="text" id="search" placeholder="🔍 Cari pengguna..." class="form-control w-50 shadow-sm">
          </div>

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
              <tbody>
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
                        'guest' => 'badge-light'
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
                      <button type="button"
                              class="btn btn-danger btn-sm rounded-pill shadow-sm"
                              onclick="confirmDelete(this.form)">
                        <i class="fas fa-trash"></i> Hapus
                      </button>
                    </form>
                  </td>                  
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div id="pagination" class="mt-4 d-flex justify-content-center"></div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- SweetAlert2 CDN -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>

<!-- Custom Scripts -->
<script>
  function confirmAdd(url) {
  Swal.fire({
    title: 'Anda ingin menambah pengguna baru?',
    text: "Anda akan diarahkan ke halaman pendaftaran.",
    icon: 'info',
    showCancelButton: true,  // Menampilkan tombol Batal
    confirmButtonText: 'Lanjutkan',
    cancelButtonText: 'Batal'  // Tombol Batal
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;  // Arahkan ke halaman tambah pengguna jika klik 'Lanjutkan'
    } else if (result.dismiss === Swal.DismissReason.cancel) {
    }
  });
}


  function confirmDelete(form) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: "Data ini tidak dapat dikembalikan!",
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
      title: 'Edit Pengguna?',
      text: "Anda akan diarahkan ke halaman edit.",
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
