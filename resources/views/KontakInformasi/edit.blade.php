@extends('adminlte.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Kontak Informasi</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada masalah dengan input kamu.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="updateForm" action="{{ route('kontak-informasi.update', $kontakInformasi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_identitas" class="form-label">Nama Identitas</label>
            <input type="text" class="form-control" id="nama_identitas" name="nama_identitas" value="{{ old('nama_identitas', $kontakInformasi->nama_identitas) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email (opsional)</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $kontakInformasi->email) }}">
        </div>

        <div class="mb-3">
            <label for="no_telpon" class="form-label">No Telpon</label>
            <input type="text" class="form-control" id="no_telpon" name="no_telpon" value="{{ old('no_telpon', $kontakInformasi->no_telpon) }}">
        </div>

        <div class="mb-3">
            <label for="no_wa" class="form-label">No WhatsApp</label>
            <input type="text" class="form-control" id="no_wa" name="no_wa" value="{{ old('no_wa', $kontakInformasi->no_wa) }}">
        </div>

        <div class="mb-3">
            <label for="instagram" class="form-label">Instagram</label>
            <input type="text" class="form-control" id="instagram" name="instagram" value="{{ old('instagram', $kontakInformasi->instagram) }}">
        </div>

        <div class="mb-3">
            <label for="fb" class="form-label">Facebook</label>
            <input type="text" class="form-control" id="fb" name="fb" value="{{ old('fb', $kontakInformasi->fb) }}">
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat">{{ old('alamat', $kontakInformasi->alamat) }}</textarea>
        </div>

        <button type="button" id="submitButton" class="btn btn-primary">Update</button>
        <a href="{{ route('kontak-informasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.min.js"></script>

<script>
    document.getElementById('submitButton').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent form from submitting immediately

        // Show SweetAlert2 confirmation
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan memperbarui informasi kontak ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, update!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                document.getElementById('updateForm').submit();
            }
        });
    });
</script>

@endsection
