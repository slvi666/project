@extends('layouts.app')

@section('title', 'Kerjakan Ujian')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<style>
    .sticky-timer {
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    .question-nav .btn {
        width: 40px;
        height: 40px;
        margin: 3px;
        padding: 0;
    }
    .question-nav .btn.answered {
        background-color: #198754;
        color: white;
    }
</style>

<div class="container my-5">
    <div class="row">
        <!-- Soal -->
        <div class="col-lg-9 animate__animated animate__fadeIn">
            <div class="bg-white shadow rounded p-4 mb-4">
                <h3 class="mb-2">{{ $exam->exam_title }}</h3>
                <p class="text-muted mb-1"><i class="bi bi-clock"></i> Durasi: {{ $exam->duration }} menit</p>
                <p class="text-muted"><i class="bi bi-info-circle"></i> {{ $exam->description }}</p>
            </div>

            <!-- Timer -->
            <div class="sticky-timer mb-3">
                <div class="progress mb-2" style="height: 10px;">
                    <div class="progress-bar bg-success" role="progressbar" id="timeProgress" style="width: 100%;"></div>
                </div>
                <div id="timer" class="alert alert-warning text-center fw-bold">
                    Sisa waktu: <span id="countdown" class="text-danger"></span>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('exam.submit', $exam->id) }}" method="POST" id="examForm">
                @csrf

                @foreach ($questions as $index => $question)
                    <div class="card mb-4 shadow-sm animate__animated animate__fadeInUp" id="question-{{ $index + 1 }}">
                        <div class="card-header bg-primary text-white fw-semibold">
                            Soal {{ $index + 1 }}
                        </div>
                        <div class="card-body">
                            <p>{!! nl2br(e($question->question_text)) !!}</p>

                            @if ($question->type === 'pilihan_ganda' && is_array($question->choices))
                                @foreach ($question->choices as $key => $choice)
                                    @php
                                        $value = substr($choice, 0, 1);
                                    @endphp
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio"
                                               name="answers[{{ $question->id }}]"
                                               value="{{ $value }}"
                                               id="q{{ $question->id }}_{{ $key }}"
                                               data-index="{{ $index + 1 }}">
                                        <label class="form-check-label" for="q{{ $question->id }}_{{ $key }}">
                                            {{ $choice }}
                                        </label>
                                    </div>
                                @endforeach
                            @elseif ($question->type === 'esai')
                                <textarea class="form-control" name="answers[{{ $question->id }}]" rows="4"
                                          placeholder="Ketik jawaban Anda..." data-index="{{ $index + 1 }}"></textarea>
                            @endif
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-success btn-lg w-100 shadow mt-4">
                    <i class="bi bi-send-check-fill"></i> Kumpulkan Jawaban
                </button>
            </form>
        </div>

        <!-- Navigasi Soal -->
        <div class="col-lg-3">
            <div class="bg-light rounded p-3 shadow-sm question-nav">
                <h5 class="text-center mb-3">Navigasi Soal</h5>
                <div class="d-flex flex-wrap justify-content-center">
                    @foreach ($questions as $index => $q)
                        <button type="button"
                                class="btn btn-outline-secondary"
                                id="nav-btn-{{ $index + 1 }}"
                                data-scroll-to="{{ $index + 1 }}">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const examId = {{ $exam->id }};
    const durationInMinutes = {{ $exam->duration }};
    const countdownEl = document.getElementById('countdown');
    const progressBar = document.getElementById('timeProgress');
    const examForm = document.getElementById('examForm');
    const totalTime = durationInMinutes * 60 * 1000;

    const storageKey = `exam_end_time_${examId}`;
    let endTime = localStorage.getItem(storageKey);

    if (!endTime) {
        endTime = new Date().getTime() + totalTime;
        localStorage.setItem(storageKey, endTime);
    } else {
        endTime = parseInt(endTime);
    }

    const timer = setInterval(() => {
        const now = new Date().getTime();
        const remaining = endTime - now;

        if (remaining <= 0) {
            clearInterval(timer);
            countdownEl.innerHTML = 'Waktu habis!';
            localStorage.removeItem(storageKey);
            examForm.submit();
        } else {
            const minutes = Math.floor(remaining / (1000 * 60));
            const seconds = Math.floor((remaining % (1000 * 60)) / 1000);
            countdownEl.innerHTML = `${minutes} menit ${seconds} detik`;

            const percent = (remaining / totalTime) * 100;
            progressBar.style.width = `${percent}%`;
        }
    }, 1000);

    function scrollToQuestion(index) {
        const el = document.getElementById('question-' + index);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function markAnswered(index) {
        const navBtn = document.getElementById('nav-btn-' + index);
        if (navBtn && !navBtn.classList.contains('answered')) {
            navBtn.classList.remove('btn-outline-secondary');
            navBtn.classList.add('btn-success', 'answered');
        }
    }

    // Handle klik tombol navigasi soal
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-scroll-to]').forEach(btn => {
            btn.addEventListener('click', function () {
                const index = this.getAttribute('data-scroll-to');
                scrollToQuestion(index);
            });
        });

        // Deteksi jawaban dan tandai
        document.querySelectorAll('input[type="radio"]').forEach(input => {
            input.addEventListener('change', function () {
                const index = this.getAttribute('data-index');
                markAnswered(index);
            });
        });

        document.querySelectorAll('textarea').forEach(input => {
            input.addEventListener('input', function () {
                const index = this.getAttribute('data-index');
                markAnswered(index);
            });
        });
    });
</script>
@endsection
