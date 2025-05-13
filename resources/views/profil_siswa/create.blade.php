@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col">
          <h1 class="m-0 text-dark">Tambah Siswa</h1>
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Tambah Siswa</li>
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
            title: 'Kesalahan!',
            html: `<ul>{!! implode('', $errors->all('<li>:message</li>')) !!}</ul>`,
            icon: 'error',
            confirmButtonText: 'OK'
          });
        </script>
      @endif

      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Form Tambah Siswa</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('profil_siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
              <label for="user_id" class="form-label">Nama Siswa</label>
              <select name="user_id" class="form-control rounded-pill px-3 py-2"
                @if(auth()->user()->role_name === 'siswa') disabled @endif required>
                @foreach ($users as $user)
                  <option value="{{ $user->id }}" {{ auth()->user()->id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} - {{ $user->email }}
                  </option>
                @endforeach
              </select>

              @if(auth()->user()->role_name === 'siswa')
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
              @endif
            </div>

            <div class="mb-3">
              <label for="nisn" class="form-label">NISN</label>
              <input type="text" name="nisn" class="form-control rounded-pill px-3 py-2" required>
            </div>

            <div class="mb-4">
              <label for="poto" class="form-label">Foto</label>
              <input type="file" name="poto" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="d-flex justify-content-start  gap-2">
              <a href="{{ route('profil_siswa.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="fas fa-save me-1"></i> Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
