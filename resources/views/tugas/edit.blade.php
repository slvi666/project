@extends('adminlte.layouts.app')

@section('content')
@php
    use Carbon\Carbon;
    $today = Carbon::now()->toDateString();
@endphp

<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Tugas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('tugas.index') }}">Daftar Tugas</a></li>
                        <li class="breadcrumb-item active">Edit Tugas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <section class="content">
        <div class="container-fluid">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Form Edit Tugas</h3>
                        </div>

                        <form action="{{ route('tugas.update', $tugas->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                @if (auth()->user()->role_name === 'guru')
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
                                                        <input type="text" name="judul_tugas" class="form-control" value="{{ $tugas->judul_tugas }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Deskripsi</label>
                                                        <textarea name="deskripsi" class="form-control">{{ $tugas->deskripsi }}</textarea>
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
                                                                <input class="form-check-input" type="checkbox" name="siswa_id[]" value="{{ $s->id }}" 
                                                                    id="siswa_{{ $s->id }}" 
                                                                    @if(in_array($s->id, $tugas->siswa->pluck('id')->toArray())) checked @endif>
                                                                <label class="form-check-label" for="siswa_{{ $s->id }}">
                                                                    {{ $s->user->name ?? '-' }} ({{ $s->subject->class_name }})
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
                                                                <option value="{{ $sub->id }}" 
                                                                    @if($sub->id == $tugas->subject_id) selected @endif>
                                                                    {{ $sub->subject_name }} - {{ $sub->class_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        <i class="fas fa-calendar-alt"></i> Tanggal dan Deadline
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#taskAccordion">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Tanggal Diberikan</label>
                                                        <input type="date" name="tanggal_diberikan" class="form-control" value="{{ $tugas->tanggal_diberikan }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Deadline</label>
                                                        <input type="date" name="deadline" class="form-control" value="{{ $tugas->deadline }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header" id="headingThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        <i class="fas fa-star"></i> Nilai dan File
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#taskAccordion">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Nilai Tugas</label>
                                                        <input type="number" name="nilai_tugas" class="form-control" value="{{ $tugas->nilai_tugas ?? '' }}" min="0" max="100" step="0.1">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>File Soal (kosongkan jika tidak diganti)</label>
                                                        <input type="file" name="file_soal" class="form-control">
                                                        @if($tugas->file_soal)
                                                            <a href="{{ asset('storage/' . $tugas->file_soal) }}" target="_blank" class="btn btn-sm btn-info mt-2">
                                                                Lihat File Soal
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label>Upload Jawaban (jika sudah dikerjakan)</label>

                                    @if ($today <= $tugas->deadline)
                                        <input type="file" name="file_jawaban" class="form-control">
                                    @else
                                        <div class="alert alert-warning mt-2">
                                            Deadline telah terlewat. Upload jawaban tidak diperbolehkan.
                                        </div>
                                    @endif

                                    @if($tugas->file_jawaban)
                                        <a href="{{ asset('storage/' . $tugas->file_jawaban) }}" target="_blank" class="btn btn-sm btn-success mt-2">
                                            Lihat Jawaban
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
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
