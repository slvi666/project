@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detail Siswa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Detail Siswa</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <!-- Card Full Width -->
            <div class="card shadow-lg rounded-3 w-100">
              <div class="card-header bg-primary text-white text-center py-4" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h3 class="card-title m-0">Informasi Siswa</h3>
              </div>
              <div class="card-body">
                <table class="table table-striped table-borderless">
                  <tbody>
                    <tr>
                      <th class="text-muted">Nama</th>
                      <td class="font-weight-bold">{{ $siswa->user->name }}</td>
                    </tr>
                    <tr>
                      <th class="text-muted">Email</th>
                      <td>{{ $siswa->user->email }}</td>
                    </tr>
                    <tr>
                      <th class="text-muted">NISN</th>
                      <td>{{ $siswa->nisn }}</td>
                    </tr>
                    <tr>
                      <th class="text-muted">Kelas</th>
                      <td>{{ $siswa->subject->class_name ?? '-' }}</td>
                    </tr>
                    <tr>
                      <th class="text-muted">Foto</th>
                      <td>
                        @if($siswa->poto)
                          <img src="{{ asset('storage/' . $siswa->poto) }}" width="150" class="rounded-circle border border-primary shadow-sm">
                        @else
                          <span class="text-muted">Tidak ada foto</span>
                        @endif
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                <!-- Menambahkan float-left untuk memposisikan tombol ke kiri -->
                <a href="{{ route('profil_siswa.index') }}" class="btn btn-secondary btn-lg px-4 py-2 shadow-sm transition-all hover:bg-gray-600 hover:scale-105 float-left">
                  Kembali
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
