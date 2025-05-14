@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Jawaban Esai</h1>

        <table class="table table-bordered">
            <tr>
                <th>Ujian</th>
                <td>{{ $essayExamResult->exam->exam_title }}</td>
            </tr>
            <tr>
                <th>Siswa</th>
                <td>{{ $essayExamResult->siswa->nisn }} - {{ $essayExamResult->siswa->user->name }}</td>
            </tr>
            <tr>
                <th>Soal Esai</th>
                <td>{{ $essayExamResult->question_text }}</td>
            </tr>
            <tr>
                <th>Jawaban Siswa</th>
                <td>{{ $essayExamResult->answer_text }}</td>
            </tr>
            <tr>
                <th>Nilai</th>
                <td>{{ $essayExamResult->score ?? 'Belum Dinilai' }}</td>
            </tr>
            <tr>
                <th>Feedback</th>
                <td>{{ $essayExamResult->feedback ?? '-' }}</td>
            </tr>
        </table>

        <a href="{{ route('essay_exam_results.index') }}" class="btn btn-primary">Kembali ke Daftar</a>
    </div>
@endsection
