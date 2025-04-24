<!-- resources/views/data_guru/index.blade.php -->
@extends('adminlte.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Daftar Guru</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Daftar Guru</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Guru</h3>
                @if(auth()->user()->role_name === 'Admin')
                <a href="{{ route('data_guru.create') }}" class="btn btn-primary float-right">Tambah Guru</a>
                @endif
              </div>
              <div class="card-body">
                @if (session('success'))
                  <script>
                    Swal.fire({
                      title: 'Berhasil!',
                      text: "{{ session('success') }}",
                      icon: 'success',
                      confirmButtonText: 'OK'
                    }).then(() => {
                      window.location.reload(); // Reload halaman setelah menutup SweetAlert
                    });
                  </script>
                @endif

                <table class="table table-bordered table-striped mt-3">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>NIP</th>
                      <th>No Telepon</th>
                      <th>Alamat</th>
                      <th>Tanggal Lahir</th>
                      @if(auth()->user()->role_name === 'Admin')
                      <th>Aksi</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($dataGuru as $guru)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $guru->user->name }}</td>
                        <td>{{ $guru->user->email }}</td>
                        <td>{{ $guru->nip }}</td>
                        <td>{{ $guru->no_telpon }}</td>
                        <td>{{ $guru->alamat }}</td>
                        <td>{{ $guru->tanggal_lahir }}</td>
                        <td>
                          @if(auth()->user()->role_name === 'Admin')
                          <a href="{{ route('data_guru.show', $guru->id) }}" class="btn btn-info btn-sm">Lihat</a>
                          <a href="{{ route('data_guru.edit', $guru->id) }}" class="btn btn-warning btn-sm">Edit</a>
                          <form action="{{ route('data_guru.destroy', $guru->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this.form)">Hapus</button>
                          </form>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
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
  </script>
@endsection
