@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Edit Kontak Informasi</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('kontak-informasi.index') }}">Kontak Informasi</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if ($errors->any())
        <script>
          Swal.fire({
            title: 'Oops!',
            html: `<ul>{!! implode('', $errors->all('<li>:message</li>')) !!}</ul>`,
            icon: 'error',
            confirmButtonText: 'Tutup'
          });
        </script>
      @endif

      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Form Edit Kontak</h5>
        </div>
        <div class="card-body">
          <form id="updateForm" action="{{ route('kontak-informasi.update', $kontakInformasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label">Nama Identitas</label>
              <input type="text" name="nama_identitas" value="{{ old('nama_identitas', $kontakInformasi->nama_identitas) }}" class="form-control rounded-pill px-3 py-2" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Email (Opsional)</label>
              <input type="email" name="email" value="{{ old('email', $kontakInformasi->email) }}" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="mb-3">
              <label class="form-label">No Telepon</label>
              <input type="text" name="no_telpon" value="{{ old('no_telpon', $kontakInformasi->no_telpon) }}" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="mb-3">
              <label class="form-label">No WhatsApp</label>
              <input type="text" name="no_wa" value="{{ old('no_wa', $kontakInformasi->no_wa) }}" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="mb-3">
              <label class="form-label">Instagram</label>
              <input type="text" name="instagram" value="{{ old('instagram', $kontakInformasi->instagram) }}" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="mb-3">
              <label class="form-label">Facebook</label>
              <input type="text" name="fb" value="{{ old('fb', $kontakInformasi->fb) }}" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="mb-4">
              <label class="form-label">Alamat</label>
              <textarea name="alamat" rows="3" class="form-control rounded-4 px-3 py-2">{{ old('alamat', $kontakInformasi->alamat) }}</textarea>
            </div>

            <div class="d-flex justify-content-start gap-2">
              <a href="{{ route('kontak-informasi.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
              </a>
              <button type="button" id="submitButton" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-edit me-1"></i> Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('submitButton').addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Anda akan memperbarui informasi kontak ini.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, update!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('updateForm').submit();
      }
    });
  });
</script>
@endsection
