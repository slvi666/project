@extends('adminlte.layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Pengumuman</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Pengumuman</li>
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
              <h3 class="card-title">Daftar Pengumuman</h3>
              <a href="{{ route('pengumuman.create') }}" class="btn btn-primary float-right">Tambah Pengumuman</a>
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

              <table class="table table-bordered table-striped mt-3">
                <thead>
                  <tr>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Berakhir</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($pengumuman as $item)
                    <tr>
                      <td>{{ $item->judul_pengumuman }}</td>
                      <td>{{ ucfirst($item->status) }}</td>
                      <td>{{ $item->tanggal_mulai }}</td>
                      <td>{{ $item->tanggal_berakhir }}</td>
                      <td>
                        <a href="{{ route('pengumuman.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('pengumuman.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this.form)">Hapus</button>
                        </form>
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

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmDelete(form) {
    Swal.fire({
      title: 'Anda yakin?',
      text: "Pengumuman ini akan dihapus!",
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
