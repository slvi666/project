
@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Tugas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('tugas.index') }}">Daftar Tugas</a></li>
                        <li class="breadcrumb-item active">Tambah Tugas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Form Tambah Tugas</h3>
                        </div>
                        <form action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="accordion" id="taskAccordion">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="fas fa-pencil-alt"></i> Judul dan Deskripsi Tugas
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#taskAccordion">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Judul Tugas</label>
                                                    <input type="text" name="judul_tugas" class="form-control" required>
                                                </div>

                                                <div class="form-group">
                                                    <label>Deskripsi</label>
                                                    <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    <i class="fas fa-users"></i> Informasi Tugas
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#taskAccordion">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Siswa</label><br>
                                                    @foreach($siswa as $s)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="siswa_id[]" value="{{ $s->id }}" id="siswa_{{ $s->id }}">
                                                            <label class="form-check-label" for="siswa_{{ $s->id }}">
                                                                {{ $s->user->name ?? '-' }}    ({{ $s->subject->class_name }})
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>                                                

                                                <div class="form-group">
                                                    <label>Guru</label>
                                                    <input type="hidden" name="guru_id" value="{{ auth()->user()->guru->id }}">
                                                    <input type="text" class="form-control" value="{{ auth()->user()->guru->nama_guru }}" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <label>Mata Pelajaran</label>
                                                    <select name="subject_id" class="form-control" required>
                                                        <option value="">-- Pilih Mapel --</option>
                                                        @foreach($subject as $sub)
                                                            <option value="{{ $sub->id }}">{{ $sub->subject_name }} - {{ $sub->class_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    <i class="fas fa-calendar-alt"></i> Tanggal dan File
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#taskAccordion">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Tanggal Diberikan</label>
                                                    <input type="date" name="tanggal_diberikan" class="form-control" required>
                                                </div>

                                                <div class="form-group">
                                                    <label>Deadline</label>
                                                    <input type="date" name="deadline" class="form-control" required>
                                                </div>

                                                <div class="form-group">
                                                    <label>File Soal</label>
                                                    <input type="file" name="file_soal" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end accordion -->
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                                <a href="{{ route('tugas.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                        </form>
                    </div> <!-- end card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
