@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah FAQ Baru</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Tambah FAQ</li>
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
              <h3 class="card-title">Form Tambah FAQ</h3>
            </div>
            <div class="card-body">
              @if ($errors->any())
                <script>
                  Swal.fire({
                    title: 'Kesalahan!',
                    html: "<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>",
                    icon: 'error',
                    confirmButtonText: 'OK'
                  });
                </script>
              @endif

              <form action="{{ route('faq.store') }}" method="POST" id="faqForm">
                @csrf
                <div class="form-group">
                  <label for="question">Pertanyaan</label>
                  <input type="text" class="form-control" id="question" name="question" value="{{ old('question') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('faq.index') }}" class="btn btn-secondary">Kembali</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Mengecek jika ada notifikasi sukses setelah submit form
  @if(session('success'))
    Swal.fire({
      title: 'Berhasil!',
      text: '{{ session('success') }}',
      icon: 'success',
      confirmButtonText: 'OK'
    });
  @endif

  // Jika form berhasil disubmit dan tidak ada error
  document.getElementById('faqForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah form disubmit secara default

    // Menampilkan SweetAlert2 sebelum melanjutkan submit
    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Data FAQ yang Anda masukkan akan disimpan.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Simpan!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        // Jika konfirmasi, lanjutkan submit form
        this.submit();
      }
    });
  });
</script>
@endsection
