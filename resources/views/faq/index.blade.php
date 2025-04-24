@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Daftar FAQ</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">FAQ</li>
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
              <div class="card-header">
                <h3 class="card-title">Pertanyaan yang Sering Diajukan</h3>
                <button class="btn btn-primary float-right" onclick="confirmAdd()">+ Tambah FAQ</button>
              </div>
              <div class="card-body">

                {{-- Notifikasi sukses --}}
                @if (session('success'))
                  <script>
                    Swal.fire({
                      title: 'Sukses!',
                      text: "{{ session('success') }}",
                      icon: 'success',
                      confirmButtonText: 'OK'
                    });
                  </script>
                @endif

                {{-- Tabel FAQ --}}
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead class="bg-primary text-white">
                      <tr>
                        <th>No</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($faqs as $faq)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $faq->question }}</td>
                          <td>{{ $faq->answer }}</td>
                          <td>
                            <button class="btn btn-sm btn-warning" onclick="confirmEdit({{ $faq->id }})">Edit</button>
                            <form action="{{ route('faq.destroy', $faq->id) }}" method="POST" style="display:inline-block;" id="delete-form-{{ $faq->id }}">
                              @csrf
                              @method('DELETE')
                              <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $faq->id }})">Hapus</button>
                            </form>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center">Belum ada FAQ</td>
                        </tr>
                      @endforelse
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

  <!-- SweetAlert2 Scripts -->
  <script>
    // SweetAlert2 for Confirming Deletion
    function confirmDelete(id) {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-form-' + id).submit();
        }
      });
    }

    // SweetAlert2 for Confirming Edit
    function confirmEdit(id) {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda akan mengedit FAQ ini.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, edit!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "{{ route('faq.edit', ':id') }}".replace(':id', id);
        }
      });
    }

    // SweetAlert2 for Confirming Add New FAQ
    function confirmAdd() {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda akan menambah FAQ baru.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, tambah!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "{{ route('faq.create') }}";
        }
      });
    }
  </script>

@endsection
