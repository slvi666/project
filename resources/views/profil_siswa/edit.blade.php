@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Siswa</h1>
          </div>
          <div class="col-sm-6">
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
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Form Edit Siswa</h3>
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
                
                <form action="{{ route('profil_siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="user_id">Nama Siswa</label>
                    <select name="user_id" class="form-control" required>
                      @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $siswa->user_id == $user->id ? 'selected' : '' }}>
                          {{ $user->name }} - {{ $user->email }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="subject_id">Kelas</label>
                    <select name="subject_id" class="form-control">
                      @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $siswa->subject_id == $subject->id ? 'selected' : '' }}>
                          {{ $subject->class_name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="nisn">NISN</label>
                    <input type="text" name="nisn" class="form-control" value="{{ $siswa->nisn }}" required>
                  </div>
                  <div class="form-group">
                    <label for="poto">Foto</label>
                    <input type="file" name="poto" class="form-control">
                    @if($siswa->poto)
                      <img src="{{ asset('storage/' . $siswa->poto) }}" width="100">
                    @endif
                  </div>
                  <button type="submit" class="btn btn-success">Update</button>
                  <a href="{{ route('profil_siswa.index') }}" class="btn btn-secondary">Batal</a>
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