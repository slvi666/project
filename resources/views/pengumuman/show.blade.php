@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-primary">Detail Pengumuman</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}" class="text-info">Pengumuman</a></li>
              <li class="breadcrumb-item active">Detail Pengumuman</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <!-- Card with rounded corners and soft shadow -->
            <div class="card shadow-lg rounded-3">
              <div class="card-header bg-primary text-white rounded-top-3">
                <h3 class="card-title">Detail Pengumuman</h3>
              </div>
              <div class="card-body">
                <table class="table table-hover table-striped">
                  <tr>
                    <th class="font-weight-bold">Judul</th>
                    <td>{{ $pengumuman->judul_pengumuman }}</td>
                  </tr>
                  <tr>
                    <th class="font-weight-bold">Status</th>
                    <td>
                      <span class="badge bg-{{ $pengumuman->status == 'aktif' ? 'success' : 'danger' }} rounded-pill">
                        {{ ucfirst($pengumuman->status) }}
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <th class="font-weight-bold">Tanggal Mulai</th>
                    <td>{{ \Carbon\Carbon::parse($pengumuman->tanggal_mulai)->format('d F Y') }}</td>
                  </tr>
                  <tr>
                    <th class="font-weight-bold">Tanggal Berakhir</th>
                    <td>{{ \Carbon\Carbon::parse($pengumuman->tanggal_berakhir)->format('d F Y') }}</td>
                  </tr>
                  <tr>
                    <th class="font-weight-bold">Isi Pengumuman</th>
                    <td>{!! nl2br(e($pengumuman->isi_pengumuman)) !!}</td>
                  </tr>
                  <tr>
                    <th class="font-weight-bold">Deskripsi</th>
                    <td>{!! nl2br(e($pengumuman->deskripsi_pengumuman)) !!}</td>
                  </tr>
                </table>
              </div>
              <div class="card-footer">
                <a href="{{ route('pengumuman.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill shadow-sm">
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
