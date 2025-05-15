@extends('layouts.app')

@section('title', 'Daftar Ujian')

@section('content')
<div class="container mt-4">
    <h3>Daftar Ujian Aktif</h3>

    @forelse ($exams as $exam)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $exam->exam_title }}</h5>
                <p>{{ $exam->description }}</p>
                <p><strong>Waktu:</strong> {{ $exam->start_time }} - {{ $exam->end_time }}</p>
                <a href="{{ route('exam.start', $exam->id) }}" class="btn btn-primary">Kerjakan</a>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Tidak ada ujian aktif saat ini.
        </div>
    @endforelse
</div>
@endsection
