@extends('layouts.app')

@section('title', 'Detail Hasil Ujian')

@section('content')
<div class="container">
    <h2 class="mb-4">Detail Hasil Ujian</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">{{ $exam->title }}</h4>
            <p><strong>Siswa:</strong> {{ $studentExam->siswa->nama }}</p>
            <p><strong>Waktu Mulai:</strong> 
            {{ $studentExam->started_at ? \Carbon\Carbon::parse($studentExam->started_at)->format('d-m-Y H:i') : '-' }}
            </p>
            <p><strong>Waktu Selesai:</strong> 
                {{ $studentExam->finished_at ? \Carbon\Carbon::parse($studentExam->finished_at)->format('d-m-Y H:i') : '-' }}
            </p>
            <p><strong>Skor Akhir:</strong> {{ $studentExam->score ?? 'Belum dinilai' }}</p>
        </div>
    </div>

    @foreach ($questions as $index => $question)
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Soal {{ $index + 1 }}</h5>
        <p><strong>Pertanyaan:</strong> {!! nl2br(e($question->question_text)) !!}</p>

        @if ($question->type === 'pilihan_ganda')
            <p><strong>Pilihan:</strong></p>
            <ul>
                @foreach ($question->choices as $key => $choice)
                    <li 
                        @if(isset($answers[$question->id]) && $answers[$question->id]->answer == $key)
                            style="font-weight:bold;"
                        @endif
                    >
                        {{ $key }}. {{ $choice }}
                        @if($question->correct_answer === $key)
                            <span class="badge bg-success">Kunci</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        <p><strong>Jawaban Siswa:</strong>
            @if(isset($answers[$question->id]))
                {{ $answers[$question->id]->answer }}
            @else
                <span class="text-muted">Belum dijawab</span>
            @endif
        </p>

        <p><strong>Skor:</strong>
            @if(isset($answers[$question->id]) && $answers[$question->id]->score !== null)
                {{ $answers[$question->id]->score }}
            @else
                <span class="text-muted">Belum dinilai</span>
            @endif
        </p>
    </div>
</div>

    @endforeach

    <a href="{{ route('student-exams.index') }}" class="btn btn-secondary mt-4">Kembali</a>
</div>
@endsection
