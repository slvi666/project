@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Siswa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Tambah Siswa</li>
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
                <h3 class="card-title">Form Tambah Siswa</h3>
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
                
                <form action="{{ route('profil_siswa.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="user_id">Nama Siswa</label>
                    <select name="user_id" class="form-control" 
                      @if(auth()->user()->role_name === 'siswa') disabled @endif required>
                      @foreach ($users as $user)
                        <option value="{{ $user->id }}" 
                          {{ auth()->user()->id == $user->id ? 'selected' : '' }}>
                          {{ $user->name }} - {{ $user->email }}
                        </option>
                      @endforeach
                    </select>
                  
                    @if(auth()->user()->role_name === 'siswa')
                      <!-- Kirim nilai via input hidden karena select-nya di-disable -->
                      <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    @endif
                  </div>
                  
                  <div class="form-group">
                    <label for="nisn">NISN</label>
                    <input type="text" name="nisn" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="poto">Foto</label>
                    <input type="file" name="poto" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-primary">Simpan</button>
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