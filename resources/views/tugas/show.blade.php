@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Detail Tugas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('tugas.index') }}">Tugas</a></li>
            <li class="breadcrumb-item active">Detail</li>
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
            <div class="card-header bg-primary text-white">
              <h3 class="card-title m-0">Detail Tugas</h3>
            </div>

            <div class="card-body">
              <!-- Grid Layout for Detail Tugas -->
              <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Judul Tugas</div>
                <div class="col-sm-9">{{ $tugas->judul_tugas }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Siswa</div>
                <div class="col-sm-9">{{ $tugas->siswa->user->name ?? '-' }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Guru</div>
                <div class="col-sm-9">{{ $tugas->guru->nama_guru }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Mapel</div>
                <div class="col-sm-9">{{ $tugas->subject->subject_name }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Deadline</div>
                <div class="col-sm-9">{{ $tugas->deadline }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Status</div>
                <div class="col-sm-9">{{ ucfirst($tugas->status) }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Deskripsi</div>
                <div class="col-sm-9">{{ $tugas->deskripsi }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">File Soal</div>
                <div class="col-sm-9">
                  @if($tugas->file_soal)
                    <a href="{{ route('tugas.download.soal', $tugas->id) }}" class="btn btn-outline-info btn-sm rounded-pill">
                      Download Soal
                    </a>
                  @else
                    <span class="badge bg-secondary">Tidak Ada</span>
                  @endif
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">File Jawaban</div>
                <div class="col-sm-9">
                  @if($tugas->file_jawaban)
                    <a href="{{ route('tugas.download.jawaban', $tugas->id) }}" class="btn btn-outline-success btn-sm rounded-pill">
                      Download Jawaban
                    </a>
                  @else
                    <span class="badge bg-secondary">Tidak Ada</span>
                  @endif
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Nilai</div>
                <div class="col-sm-9">
                  @if($tugas->nilai_tugas !== null)
                    {{ $tugas->nilai_tugas }}
                  @else
                    <span class="text-muted">Belum dinilai</span>
                  @endif
                </div>
              </div>

              <!-- Back Button -->
              <div class="text-left">
                <a href="{{ route('tugas.index') }}" class="btn btn-secondary btn-sm rounded-pill">Kembali</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
