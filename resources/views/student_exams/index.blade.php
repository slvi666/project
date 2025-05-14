@extends('layouts.app')

@section('content')
    <h1>Student Exams</h1>
    <a href="{{ route('student_exams.create') }}">Add New Student Exam</a>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Siswa</th>
                <th>Exam</th>
                <th>Started At</th>
                <th>Finished At</th>
                <th>Score</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($studentExams as $studentExam)
                <tr>
                    <td>
                        @if($studentExam->siswa && $studentExam->siswa->user)
                            {{ $studentExam->siswa->user->name }}
                        @else
                            Data Siswa Tidak Ditemukan
                        @endif
                    </td>
                    <td>{{ $studentExam->exam->exam_title }}</td>
                    <td>{{ $studentExam->started_at }}</td>
                    <td>{{ $studentExam->finished_at }}</td>
                    <td>{{ $studentExam->score }}</td>
                    <td>
                        <a href="{{ route('student_exams.edit', $studentExam->id) }}">Edit</a>
                        <form action="{{ route('student_exams.destroy', $studentExam->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                        <a href="{{ route('student_exams.show', $studentExam->id) }}">Show</a>

                        {{-- Tombol Hitung Skor --}}
                        <form action="{{ route('student_exams.calculateScore', $studentExam->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Hitung Skor</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
