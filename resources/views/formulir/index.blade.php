@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-md-6">
            <h1 class="m-0">Daftar Formulir Pendaftaran</h1>
          </div>
          <div class="col-md-6">
            <ol class="breadcrumb float-md-right">
              <li class="breadcrumb-item active">Daftar Formulir Pendaftaran</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Formulir</h3>
                <a href="{{ route('formulir.create') }}" class="btn btn-primary">Tambah Pendaftaran</a>
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
                
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead class="bg-primary text-white">

                      <tr>
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>NIK</th>
                        <th>TTL</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Nama Orangtua</th>
                        <th>Asal Sekolah</th>
                        <th>Tahun Lulus</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($formulirs as $formulir)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $formulir->user->name }}</td>
                          <td>{{ $formulir->user->email }}</td>
                          <td>{{ $formulir->nik }}</td>
                          <td>{{ $formulir->tempat_lahir }}, {{ $formulir->tanggal_lahir }}</td>
                          <td>{{ $formulir->jenis_kelamin }}</td>
                          <td>{{ $formulir->agama }}</td>
                          <td>{{ $formulir->no_hp }}</td>
                          <td>{{ $formulir->alamat }}</td>
                          <td>{{ $formulir->nama_orangtua }}</td>
                          <td>{{ $formulir->asal_sekolah }}</td>
                          <td>{{ $formulir->tahun_lulus }}</td>
                          <td><img src="{{ asset('storage/' . $formulir->foto) }}" class="img-thumbnail" width="50" alt="Foto"></td>
                          <td>{{ $formulir->status }}</td>
                          <td>
                            <div class="btn-group" role="group">
                              <a href="{{ route('formulir.show', $formulir->id) }}" class="btn btn-info">Detail</a>
                              <button type="button" class="btn btn-warning" onclick="confirmEdit('{{ route('formulir.edit', $formulir->id) }}')">Edit</button>
                              <form action="{{ route('formulir.destroy', $formulir->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(this.form)">Hapus</button>
                              </form>
                            </div>
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

    function confirmEdit(url) {
      Swal.fire({
        title: 'Anda yakin ingin mengedit?',
        text: "Anda akan diarahkan ke halaman edit.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Ya, lanjutkan!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          document.location.href = url;
        }
      });
    }
  </script>
@endsection
