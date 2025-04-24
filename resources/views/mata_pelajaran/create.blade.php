@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah Mata Pelajaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('mata-pelajaran.index') }}">Mata Pelajaran</a></li>
            <li class="breadcrumb-item active">Tambah</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Form Tambah Mata Pelajaran</h3>
            </div>
            <form action="{{ route('mata-pelajaran.store') }}" method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="subject_id">Mata Pelajaran</label>
                  <select name="subject_id" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    @foreach ($subjects as $subject)
                      <option value="{{ $subject->id }}">{{ $subject->subject_name }} ({{ $subject->class_name }})</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="guru_id">Guru</label>
                  <select name="guru_id" class="form-control" required>
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($gurus as $guru)
                      <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="siswa_ids">Siswa</label>
                  <select name="siswa_ids[]" class="form-control" multiple required>
                    @foreach ($siswa as $s)
                      <option value="{{ $s->id }}">{{ $s->user->name }}</option>
                    @endforeach
                  </select>
                  <small class="text-muted">* Gunakan Ctrl (Windows) / Command (Mac) untuk pilih lebih dari satu</small>
                </div>

                <div class="form-group">
                  <label>Waktu Mulai</label>
                  <input type="time" name="waktu_mulai" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Waktu Berakhir</label>
                  <input type="time" name="waktu_berakhir" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Hari</label>
                  <select name="hari" class="form-control" required>
                    @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                      <option value="{{ $hari }}">{{ $hari }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="card-footer">
                <button class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('mata-pelajaran.index') }}" class="btn btn-secondary">Kembali</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
