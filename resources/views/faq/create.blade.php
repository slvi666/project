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
      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Form Tambah FAQ</h5>
        </div>
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger mb-4">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('faq.store') }}" method="POST" id="faqForm">
            @csrf
            <div class="mb-3">
              <label for="question" class="form-label">Pertanyaan</label>
              <input type="text" class="form-control rounded-pill px-3 py-2" id="question" name="question" value="{{ old('question') }}" required>
            </div>

            <div class="d-flex justify-content-start gap-2">
              <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-save me-1"></i> Simpan
              </button>
              <a href="{{ route('faq.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Menampilkan notifikasi sukses setelah submit form
  @if(session('success'))
    Swal.fire({
      title: 'Berhasil!',
      text: '{{ session('success') }}',
      icon: 'success',
      confirmButtonText: 'OK'
    });
  @endif

  // Menambahkan konfirmasi sebelum submit form
  document.getElementById('faqForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah form disubmit secara default

    // Menampilkan SweetAlert2 untuk konfirmasi
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
