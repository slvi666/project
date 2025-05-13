<!-- resources/views/exams/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Ujian: {{ $exam->exam_title }}</h1>
        <p><strong>Mata Pelajaran:</strong> {{ $exam->subject->name }}</p>
        <p><strong>Jenis Soal:</strong> {{ ucfirst(str_replace('_', ' ', $exam->question_type)) }}</p>
        <p><strong>Durasi:</strong> {{ $exam->duration }} menit</p>
        <p><strong>Waktu Mulai:</strong> {{ $exam->start_time ? $exam->start_time->format('Y-m-d H:i') : '-' }}</p>
        <p><strong>Waktu Selesai:</strong> {{ $exam->end_time ? $exam->end_time->format('Y-m-d H:i') : '-' }}</p>
        <a href="{{ route('exams.index') }}" class="btn btn-primary">Kembali ke Daftar</a>
    </div>
@endsection
