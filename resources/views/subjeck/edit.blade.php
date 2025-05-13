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
              <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Daftar Mata Pelajaran</a></li>
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
            <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label for="class_name" class="form-label">Nama Kelas</label>
                <input type="text" name="class_name" class="form-control rounded-pill px-3 py-2" value="{{ $subject->class_name }}" required>
              </div>

              <div class="mb-3">
                <label for="subject_name" class="form-label">Nama Mata Pelajaran</label>
                <input type="text" name="subject_name" class="form-control rounded-pill px-3 py-2" value="{{ $subject->subject_name }}" required>
              </div>

              <div class="d-flex justify-content-start gap-2">
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
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
    </section>
  </div>
@endsection
