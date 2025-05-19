@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Edit Siswa</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Edit Siswa</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">Form Edit Siswa</h5>
            </div>
            <div class="card-body">

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

              <form action="{{ route('profil_siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

<div class="mb-3">
  <label for="user_id" class="form-label">Nama Siswa</label>
  <input type="text" class="form-control rounded-pill px-3 py-2" value="{{ $siswa->user->name }} - {{ $siswa->user->email }}" readonly>
  <input type="hidden" name="user_id" value="{{ $siswa->user_id }}">
</div>


                <div class="mb-3">
                  <label for="subject_id" class="form-label">Kelas</label>
                  <select name="subject_id" class="form-control rounded-pill px-3 py-2">
                    @foreach($subjects as $subject)
                      <option value="{{ $subject->id }}" {{ $siswa->subject_id == $subject->id ? 'selected' : '' }}>
                        {{ $subject->class_name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label for="nisn" class="form-label">NISN</label>
                  <input type="text" name="nisn" class="form-control rounded-pill px-3 py-2" value="{{ $siswa->nisn }}" required>
                </div>

                <div class="mb-4">
                  <label for="poto" class="form-label">Foto</label>
                  <input type="file" name="poto" class="form-control rounded-pill px-3 py-2">
                  @if($siswa->poto)
                    <div class="mt-2">
                      <img src="{{ asset('storage/' . $siswa->poto) }}" width="100" class="img-thumbnail">
                    </div>
                  @endif
                </div>

                <div class="d-flex justify-content-start gap-2">
                  <a href="{{ route('profil_siswa.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Batal
                  </a>
                  <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                    <i class="fas fa-save me-1"></i> Update
                  </button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
