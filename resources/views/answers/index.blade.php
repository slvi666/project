@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Jawaban</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('answers.create') }}" class="btn btn-primary mb-3">Tambah Jawaban</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Exam</th>
                <th>Soal</th>
                <th>Jawaban</th>
                <th>Skor</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($answers as $answer)
                <tr>
                    <td>{{ $answer->id }}</td>
                    <td>{{ $answer->student_exam_id }}</td>
                    <td>{{ $answer->question_id }}</td>
                    <td>{{ $answer->answer_text }}</td>
                    <td>{{ $answer->score ?? 'Belum dinilai' }}</td>
                    <td>
                        <a href="{{ route('answers.show', $answer->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('answers.edit', $answer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('answers.destroy', $answer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                        <a href="{{ route('answers.autoGrade', $answer->id) }}" class="btn btn-success btn-sm">Auto Nilai</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
