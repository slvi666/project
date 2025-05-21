@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $exam->exam_title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Ujian</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Soal -->
                <div class="col-lg-9">
                    <div class="card shadow animate__animated animate__fadeIn">
                        <div class="card-header bg-primary text-white fw-bold">
                            <i class="bi bi-journal-text me-2"></i> {{ $exam->exam_title }}
                        </div>
                        <div class="card-body">
                            <p class="text-muted"><i class="bi bi-clock me-1"></i> Durasi: {{ $exam->duration }} menit</p>
                            <p class="text-muted"><i class="bi bi-info-circle me-1"></i> {{ $exam->description }}</p>

                            <!-- Timer -->
                            <div class="sticky-top bg-white py-2 z-10">
                                <div class="progress mb-2" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar" id="timeProgress" style="width: 100%;"></div>
                                </div>
                                <div id="timer" class="alert alert-warning text-center fw-bold">
                                    Sisa waktu: <span id="countdown" class="text-danger"></span>
                                </div>
                            </div>

                            <form action="{{ route('exam.submit', $exam->id) }}" method="POST" id="examForm">
                                @csrf

                                @foreach ($questions as $index => $question)
                                    <div class="card mb-4 shadow-sm question-card animate__animated animate__fadeInUp"
                                         id="question-{{ $index + 1 }}"
                                         style="display: {{ $index === 0 ? 'block' : 'none' }};">
                                        <div class="card-header bg-primary text-white">
                                            Soal {{ $index + 1 }}
                                        </div>
                                        <div class="card-body">
                                            <p>{!! nl2br(e($question->question_text)) !!}</p>

                                            @if ($question->type === 'pilihan_ganda' && is_array($question->choices))
                                                @foreach ($question->choices as $key => $choice)
                                                    @php $value = substr($choice, 0, 1); @endphp
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

                                <!-- Navigation Buttons -->
                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button" class="btn btn-secondary" id="prevBtn">Sebelumnya</button>
                                    <button type="button" class="btn btn-primary" id="nextBtn">Selanjutnya</button>
                                   <button type="button" class="btn btn-success d-none" id="submitBtn" disabled>
                                        <i class="bi bi-send-check-fill me-1"></i> Akhiri Ujian
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Navigasi Soal -->
                <div class="col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white text-center">
                            Navigasi Soal
                        </div>
                        <div class="card-body d-flex flex-wrap justify-content-center question-nav">
                            @foreach ($questions as $index => $q)
                                <button type="button"
                                        class="btn btn-outline-secondary m-1"
                                        id="nav-btn-{{ $index + 1 }}"
                                        style="width: 45px; height: 45px;"
                                        onclick="showQuestion({{ $index + 1 }})">
                                    {{ $index + 1 }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<!-- Styles -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<style>
    .question-nav .btn.answered {
        background-color: #198754;
        color: white;
    }
</style>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
      const examId = {{ $exam->id }};
    const durationInMinutes = {{ $exam->duration }};
    const totalTime = durationInMinutes * 60 * 1000;
    const storageKey = `exam_end_time_${examId}`;
    const countdownEl = document.getElementById('countdown');
    const progressBar = document.getElementById('timeProgress');
    const examForm = document.getElementById('examForm');
    const totalQuestions = {{ count($questions) }};
    let currentIndex = 1;

    // Timer
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

    function showQuestion(index) {
        document.querySelectorAll('.question-card').forEach((el, i) => {
            el.style.display = (i + 1 === index) ? 'block' : 'none';
        });
        currentIndex = index;
        updateNavigationButtons();
    }

    function updateNavigationButtons() {
        document.getElementById('prevBtn').style.display = currentIndex === 1 ? 'none' : 'inline-block';
        document.getElementById('nextBtn').style.display = currentIndex === totalQuestions ? 'none' : 'inline-block';
        document.getElementById('submitBtn').classList.toggle('d-none', currentIndex !== totalQuestions);
    }

    function markAnswered(index) {
        const navBtn = document.getElementById('nav-btn-' + index);
        if (navBtn && !navBtn.classList.contains('answered')) {
            navBtn.classList.remove('btn-outline-secondary');
            navBtn.classList.add('btn-success', 'answered');
        }
    }

    // ✅ Fungsi untuk mengecek semua soal sudah dijawab
    function checkAllAnswered() {
        let allAnswered = true;

        @foreach ($questions as $question)
            @if ($question->type === 'pilihan_ganda')
                if (!document.querySelector('input[name="answers[{{ $question->id }}]"]:checked')) {
                    allAnswered = false;
                }
            @elseif ($question->type === 'esai')
                if (!document.querySelector('textarea[name="answers[{{ $question->id }}]"]').value.trim()) {
                    allAnswered = false;
                }
            @endif
        @endforeach

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = !allAnswered;
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateNavigationButtons();
        checkAllAnswered(); // Cek awal

        document.querySelectorAll('input[type="radio"]').forEach(input => {
            input.addEventListener('change', function () {
                const index = this.getAttribute('data-index');
                markAnswered(index);
                checkAllAnswered();
            });
        });

        document.querySelectorAll('textarea').forEach(input => {
            input.addEventListener('input', function () {
                const index = this.getAttribute('data-index');
                markAnswered(index);
                checkAllAnswered();
            });
        });


        document.getElementById('prevBtn').addEventListener('click', () => {
            if (currentIndex > 1) {
                showQuestion(currentIndex - 1);
            }
        });

        document.getElementById('nextBtn').addEventListener('click', () => {
            if (currentIndex < totalQuestions) {
                showQuestion(currentIndex + 1);
            }
        });
    });
    
    document.getElementById('submitBtn').addEventListener('click', function (e) {
    Swal.fire({
        title: 'Yakin ingin mengakhiri ujian?',
        text: "Pastikan semua soal telah dijawab.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, kumpulkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            examForm.submit();
        }
    });
});

</script>
@endsection
