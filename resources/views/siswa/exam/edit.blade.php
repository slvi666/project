@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Edit Hasil Ujian: {{ $exam->exam_title }}</h1>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h3 class="card-title">Detail Ujian</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('siswa.exam.update', $studentExam->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label">Judul Ujian</label>
              <input type="text" class="form-control" value="{{ $exam->exam_title }}" disabled>
            </div>

            <div class="mb-3">
              <label class="form-label">Nama Siswa</label>
              <input type="text" class="form-control" value="{{ $studentExam->siswa->user->name }}" disabled>
            </div>

            <div class="mb-3">
              <label class="form-label">Skor Total</label>
              <input type="number" class="form-control" name="score" value="{{ $studentExam->score }}" required>
            </div>

            <hr>

            <h4 class="mb-3">Jawaban Siswa</h4>

            @foreach ($questions as $index => $question)
              <div class="card mb-4">
                <div class="card-header bg-light">
                  Soal {{ $index + 1 }}
                </div>
                <div class="card-body">
                  <p>{!! nl2br(e($question->question_text)) !!}</p>

                  @if ($question->type === 'pilihan_ganda')
                    @foreach ($question->choices as $key => $choice)
                      @php $value = substr($choice, 0, 1); @endphp
                      <div class="form-check">
                        <input class="form-check-input" type="radio"
                               name="answers[{{ $question->id }}]"
                               value="{{ $value }}"
                               {{ isset($answers[$question->id]) && $answers[$question->id]->answer === $value ? 'checked' : '' }}
                               disabled>
                        <label class="form-check-label">
                          {{ $choice }}
                        </label>
                      </div>
                    @endforeach

                  @elseif ($question->type === 'esai')
                    <label class="form-label">Jawaban Esai:</label>
                    <textarea class="form-control" rows="4" disabled>{{ $answers[$question->id]->answer ?? '' }}</textarea>
                  @endif

                  {{-- Hanya untuk admin/teacher supaya bisa input nilai per soal --}}
                  @if (Auth::user()->role !== 'siswa')
                    <div class="mt-3">
                      <label class="form-label">Nilai untuk soal ini</label>
                      <input type="number" name="manual_scores[{{ $question->id }}]"
                             class="form-control"
                             min="0" max="100"
                             value="{{ $answers[$question->id]->score ?? '' }}">
                    </div>
                  @endif
                </div>
              </div>
            @endforeach

            <div class="d-flex justify-content-between">
              <a href="{{ route('student-exams.index') }}" class="btn btn-secondary">Kembali</a>
              <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
