@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Jawaban Esai</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('essay_exam_results.create') }}" class="btn btn-primary mb-3">Tambah Jawaban Esai</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Ujian</th>
                    <th>Nilai</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $result)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result->exam->exam_title }}</td>
                        <td>{{ $result->score ?? 'Belum Dinilai' }}</td>
                        <td>{{ $result->feedback ?? '-' }}</td>
                        <td>
                            <a href="{{ route('essay_exam_results.show', $result->id) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('essay_exam_results.edit', $result->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('essay_exam_results.destroy', $result->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $results->links() }}
    </div>
@endsection
