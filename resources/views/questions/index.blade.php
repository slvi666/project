@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Soal untuk Ujian: {{ $exam->exam_title }}</h1>

    <a href="{{ route('questions.create', $exam->id) }}" class="btn btn-primary">Tambah Soal</a>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Soal</th>
                <th>Jenis Soal</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->question_text }}</td>
                    <td>{{ $question->type }}</td>
                    <td>
                        <a href="{{ route('questions.edit', [$exam->id, $question->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('questions.destroy', [$exam->id, $question->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
