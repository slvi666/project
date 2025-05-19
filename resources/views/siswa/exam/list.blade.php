{{-- resources/views/siswa/exam/list.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Ujian</h1>

    @if($exams->isEmpty())
        <p>Tidak ada ujian tersedia.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Ujian</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exams as $exam)
                    <tr>
                        <td>{{ $exam->name }}</td>
                        <td>{{ $exam->description }}</td>
                        <td>
                            @if ($exam->joined)
                                <span class="badge bg-success">Sudah Mengikuti</span><br>
                                <small>{{ $exam->pivot_finished_at ? $exam->pivot_finished_at->format('d M Y H:i') : '-' }}</small>
                            @else
                                <span class="badge bg-warning text-dark">Belum Mengikuti</span>
                            @endif
                        </td>
                        <td>
                            {{ $exam->pivot_score !== null ? $exam->pivot_score : '-' }}
                        </td>
                        <td>
                            @if (!$exam->joined)
                                <a href="{{ route('exams.start', $exam->id) }}" class="btn btn-primary btn-sm">Mulai Ujian</a>
                            @else
                                <a href="#" class="btn btn-secondary btn-sm disabled">Selesai</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
