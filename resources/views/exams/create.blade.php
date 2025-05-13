<!-- resources/views/exams/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Ujian Baru</h1>

        <form action="{{ route('exams.store') }}" method="POST">
            @csrf

<div class="form-group">
    <label for="subject_id">Mata Pelajaran</label>
    <select name="subject_id" id="subject_id" class="form-control">
        @foreach($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option> <!-- Menggunakan subject_name -->
        @endforeach
    </select>
</div>


            <div class="form-group">
                <label for="exam_title">Judul Ujian</label>
                <input type="text" name="exam_title" id="exam_title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="question_type">Jenis Soal</label>
                <select name="question_type" id="question_type" class="form-control" required>
                    <option value="pilihan_ganda">Pilihan Ganda</option>
                    <option value="esai">Esai</option>
                    <option value="campuran">Campuran</option>
                </select>
            </div>

            <div class="form-group">
                <label for="duration">Durasi (Menit)</label>
                <input type="number" name="duration" id="duration" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="start_time">Waktu Mulai</label>
                <input type="datetime-local" name="start_time" id="start_time" class="form-control">
            </div>

            <div class="form-group">
                <label for="end_time">Waktu Selesai</label>
                <input type="datetime-local" name="end_time" id="end_time" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
@endsection
