@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Hasil Ujian Anda</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Hasil Ujian</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-lg rounded">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              <h3 class="card-title m-0">Daftar Hasil Ujian</h3>
              <!-- kamu bisa tambahkan tombol atau tools di sini jika perlu -->
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th style="width: 5%;">No</th>
                      <th>Nama Siswa</th>
                      <th>Judul Ujian</th>
                      <th>Dimulai</th>
                      <th>Selesai</th>
                      <th>Skor</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($studentExams as $index => $exam)
                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $exam->siswa->user->name ?? 'Nama tidak tersedia' }}</td>
                        <td>{{ $exam->exam->exam_title }}</td>
<td>{{ \Carbon\Carbon::parse($exam->started_at)->translatedFormat('l, d F Y H:i') ?? '-' }}</td>
<td>{{ \Carbon\Carbon::parse($exam->finished_at)->translatedFormat('l, d F Y H:i') ?? '-' }}</td>

                        <td>{{ $exam->score !== null ? $exam->score : 'Belum dinilai' }}</td>
                      </tr>
                    @endforeach
                    @if(count($studentExams) === 0)
                      <tr>
                        <td colspan="6" class="text-center">Tidak ada data hasil ujian.</td>
                      </tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
