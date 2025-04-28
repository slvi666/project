@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0 text-primary">Detail Jadwal Pelajaran</h1>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-lg rounded-4">
        <div class="card-header bg-gradient-success text-white rounded-top">
          <h3 class="card-title">Detail Mata Pelajaran</h3>
        </div>

        <div class="card-body">
          <table class="table table-bordered">
            <tr>
              <th>Nama Mapel</th>
              <td>{{ $data->subject->subject_name }}</td>
            </tr>
            <tr>
              <th>Kelas</th>
              <td>{{ $data->subject->class_name }}</td>
            </tr>
            <tr>
              <th>Guru</th>
              <td>{{ $data->guru ? $data->guru->name : '-' }}</td>
            </tr>
            <tr>
              <th>Hari</th>
              <td>{{ $data->hari }}</td>
            </tr>
            <tr>
              <th>Waktu</th>
              <td>{{ substr($data->waktu_mulai, 0, 5) }} - {{ substr($data->waktu_berakhir, 0, 5) }}</td>
            </tr>
          </table>

          <a href="{{ route('mataelajaran.index') }}" class="btn btn-secondary mt-3 rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Kembali
          </a>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
