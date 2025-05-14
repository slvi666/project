@extends('layouts.app')

@section('content')
    <h1>Add New Student Exam</h1>
    <form action="{{ route('student_exams.store') }}" method="POST">
        @csrf
        <div>
            <label for="siswa_id">Siswa</label>
            <select name="siswa_id">
                @foreach($siswa as $s)
                    <option value="{{ $s->id }}">{{ $s->user->name }}</option>

                @endforeach
            </select>
        </div>

        <div>
            <label for="exam_id">Exam</label>
            <select name="exam_id">
                @foreach($exams as $exam)
                    <option value="{{ $exam->id }}">{{ $exam->exam_title }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="started_at">Started At</label>
            <input type="datetime-local" name="started_at" required>
        </div>

        <div>
            <label for="finished_at">Finished At</label>
            <input type="datetime-local" name="finished_at">
        </div>

        <div>
            <label for="score">Score</label>
            <input type="number" name="score">
        </div>

        <button type="submit">Save</button>
    </form>
@endsection
