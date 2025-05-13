<!-- resources/views/exams/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Ujian</h1>
        <a href="{{ route('exams.create') }}" class="btn btn-primary mb-3">Tambah Ujian Baru</a>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul Ujian</th>
                    <th>Mata Pelajaran</th>
                    <th>Jenis Soal</th>
                    <th>Durasi</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exams as $exam)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $exam->exam_title }}</td>
                        <td>{{ $exam->subject->subject_name }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $exam->question_type)) }}</td>
                        <td>{{ $exam->duration }} menit</td>
                       <td>{{ $exam->start_time ? \Carbon\Carbon::parse($exam->start_time)->format('Y-m-d H:i') : '-' }}</td>
<td>{{ $exam->end_time ? \Carbon\Carbon::parse($exam->end_time)->format('Y-m-d H:i') : '-' }}</td>

                        <td>
                            <a href="{{ route('exams.show', $exam->id) }}" class="btn btn-info">Lihat</a>
                            <a href="{{ route('exams.edit', $exam->id) }}" class="btn btn-warning">Edit</a>
                             <a href="{{ route('questions.index', $exam->id) }}" class="btn btn-primary">Soal</a>
                            <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
