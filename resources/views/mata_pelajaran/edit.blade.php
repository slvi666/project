@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-3">
          <div class="col-md-6">
            <h1 class="m-0 text-dark">Edit Mata Pelajaran</h1>
          </div>
          <div class="col-md-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('mata-pelajaran.index') }}">Mata Pelajaran</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="card shadow-sm border-0 rounded-lg">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Edit Mata Pelajaran</h5>
          </div>
          <div class="card-body">
            @if ($errors->has('msg'))
              <div class="alert alert-danger">
                {{ $errors->first('msg') }}
              </div>
            @endif

            <form action="{{ route('mata-pelajaran.update', $data->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label for="subject_id" class="form-label">Mata Pelajaran</label>
                <select name="subject_id" class="form-control rounded-pill px-3 py-2" required>
                  @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $data->subject_id == $subject->id ? 'selected' : '' }}>
                      {{ $subject->subject_name }} ({{ $subject->class_name }})
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="guru_id" class="form-label">Guru</label>
                <select name="guru_id" class="form-control rounded-pill px-3 py-2" required>
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
                <small class="text-muted">* Pilih satu atau lebih siswa</small>
              </div>

              <div class="mb-3">
                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                <input type="time" name="waktu_mulai" value="{{ $data->waktu_mulai }}" class="form-control rounded-pill px-3 py-2" required>
              </div>

              <div class="mb-3">
                <label for="waktu_berakhir" class="form-label">Waktu Berakhir</label>
                <input type="time" name="waktu_berakhir" value="{{ $data->waktu_berakhir }}" class="form-control rounded-pill px-3 py-2" required>
              </div>

              <div class="mb-3">
                <label for="hari" class="form-label">Hari</label>
                <select name="hari" class="form-control rounded-pill px-3 py-2" required>
                  @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                    <option value="{{ $hari }}" {{ $data->hari == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                  @endforeach
                </select>
              </div>

              <div class="d-flex justify-content-start gap-2">
                <a href="{{ route('mata-pelajaran.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                  <i class="fas fa-arrow-left me-1"></i> Kembali
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
  </section>
</div>
@endsection
