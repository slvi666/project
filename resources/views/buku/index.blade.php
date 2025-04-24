@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Daftar Buku</h1>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Buku</h3>
                @if (auth()->user()->role_name === 'Admin')
                <div class="card-tools">
                  <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
                </div>
                @endif
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

                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Cover</th>
                      <th>Judul</th>
                      <th>Penulis</th>
                      <th>Kategori</th>
                      <th>Views</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($buku as $index => $item)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><img src="{{ asset('storage/' . $item->cover_buku) }}" alt="Cover Buku" width="50"></td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->penulis }}</td>
                        <td>{{ ucfirst($item->kategori) }}</td>
                        <td>{{ $item->views }}</td>
                        <td>
                          <a href="{{ route('buku.show', $item->id) }}" class="btn btn-info">Detail</a>
                          @if (auth()->user()->role_name === 'Admin')
                          <button type="button" class="btn btn-warning" onclick="confirmEdit('{{ route('buku.edit', $item->id) }}')">Edit</button>
                          <form action="{{ route('buku.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(this.form)">Hapus</button>
                          </form>
                        </td>
                          @endif
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
