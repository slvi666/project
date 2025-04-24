@extends('adminlte.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Kontak Informasi</h1>

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

    <form action="{{ route('kontak-informasi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama_identitas" class="form-label">Nama Identitas</label>
            <input type="text" class="form-control" id="nama_identitas" name="nama_identitas" value="{{ old('nama_identitas') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email (opsional)</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="no_telpon" class="form-label">No Telpon</label>
            <input type="text" class="form-control" id="no_telpon" name="no_telpon" value="{{ old('no_telpon') }}">
        </div>

        <div class="mb-3">
            <label for="no_wa" class="form-label">No WhatsApp</label>
            <input type="text" class="form-control" id="no_wa" name="no_wa" value="{{ old('no_wa') }}">
        </div>

        <div class="mb-3">
            <label for="instagram" class="form-label">Instagram</label>
            <input type="text" class="form-control" id="instagram" name="instagram" value="{{ old('instagram') }}">
        </div>

        <div class="mb-3">
            <label for="fb" class="form-label">Facebook</label>
            <input type="text" class="form-control" id="fb" name="fb" value="{{ old('fb') }}">
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat">{{ old('alamat') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('kontak-informasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
