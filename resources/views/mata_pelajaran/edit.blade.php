@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Mata Pelajaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('mata-pelajaran.index') }}">Daftar Mata Pelajaran</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Form Edit Mata Pelajaran</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('mata-pelajaran.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="subject_id" class="form-label">Mata Pelajaran</label>
              <select name="subject_id" class="form-control" required>
                @foreach ($subjects as $subject)
                  <option value="{{ $subject->id }}" {{ $data->subject_id == $subject->id ? 'selected' : '' }}>
                    {{ $subject->subject_name }} ({{ $subject->class_name }})
                  </option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="guru_id" class="form-label">Guru</label>
              <select name="guru_id" class="form-control" required>
                @foreach ($gurus as $guru)
                  <option value="{{ $guru->id }}" {{ $data->guru_id == $guru->id ? 'selected' : '' }}>
                    {{ $guru->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="siswa_ids" class="form-label">Siswa</label>
              <div>
                @foreach ($siswa as $s)
                  <div class="form-check">
                    <input type="checkbox" name="siswa_ids[]" class="form-check-input" value="{{ $s->id }}"
                      {{ in_array($s->id, $data->siswa_ids) ? 'checked' : '' }}>
                    <label class="form-check-label" for="siswa_ids">
                      {{ $s->user->name }}
                    </label>
                  </div>
                @endforeach
              </div>
            </div>            

            <div class="mb-3">
              <label>Waktu Mulai</label>
              <input type="time" name="waktu_mulai" value="{{ $data->waktu_mulai }}" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Waktu Berakhir</label>
              <input type="time" name="waktu_berakhir" value="{{ $data->waktu_berakhir }}" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Hari</label>
              <select name="hari" class="form-control" required>
                @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                  <option value="{{ $hari }}" {{ $data->hari == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                @endforeach
              </select>
            </div>

            <button class="btn btn-success">Update</button>
            <a href="{{ route('mata-pelajaran.index') }}" class="btn btn-secondary">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
