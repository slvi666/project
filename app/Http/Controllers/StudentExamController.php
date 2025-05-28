<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Answer;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentExam;


class StudentExamController extends Controller
{
    // Menampilkan halaman ujian dan soal-soalnya
    public function start(Exam $exam)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $siswa->exams()->syncWithoutDetaching([
            $exam->id => ['started_at' => now()]
        ]);

        // Ambil semua soal terkait ujian ini
        $questions = $exam->questions;

        // Decode choices JSON ke array
        $questions->transform(function ($question) {
            if (is_string($question->choices)) {
                $question->choices = json_decode($question->choices, true);
            }
            return $question;
        });

        return view('siswa.exam.start', compact('exam', 'questions'));
    }

    // Menyimpan jawaban siswa dan hitung skor
    public function submit(Request $request, Exam $exam)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $answers = $request->input('answers', []);
        $scoreTotal = 0;
        $counted = 0;

        foreach ($exam->questions as $question) {
            $studentAnswer = $answers[$question->id] ?? null;
            $score = null;

            // Skor otomatis hanya untuk soal pilihan ganda
            if ($question->type === 'pilihan_ganda') {
                $score = ($studentAnswer == $question->correct_answer) ? 100 : 0;
                $scoreTotal += $score;
                $counted++;
            }

            // Simpan atau update jawaban siswa
            Answer::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'exam_id' => $exam->id,
                    'question_id' => $question->id,
                ],
                [
                    'answer' => $studentAnswer,
                    'score' => $score,
                ]
            );
        }

        // Hitung nilai akhir (rata-rata soal pilihan ganda)
        $finalScore = $counted > 0 ? round($scoreTotal / $counted) : null;

        // Update pivot table untuk catat selesai dan skor
        $siswa->exams()->updateExistingPivot($exam->id, [
            'finished_at' => now(),
            'score' => $finalScore,
        ]);

        return redirect()->route('exams.index')
                         ->with('success', 'Ujian selesai. Nilai Anda: ' . ($finalScore ?? 'Menunggu penilaian'));
    }

    // List ujian yang tersedia untuk siswa
    public function list()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $exams = Exam::whereHas('siswa', function ($query) use ($siswa) {
                        $query->where('siswa_id', $siswa->id);
                    })
                    ->where('start_time', '<=', now())
                    ->where('end_time', '>=', now())
                    ->get();

        return view('siswa.exam.list', compact('exams'));
    }
public function index()
{
    $user = Auth::user();

    // Cek role user
    $role = $user->role_name;

    if ($role === 'siswa') {
        // Ambil data siswa
        $siswa = Siswa::where('user_id', $user->id)->first();

        if ($siswa) {
            // Tampilkan hanya ujian milik siswa ini
            $studentExams = $siswa->studentExams()
                ->with('exam')
                ->latest('finished_at')
                ->get();
        } else {
            // Tidak ada data siswa, kosongkan
            $studentExams = collect();
        }
    } elseif ($role === 'guru') {
        // Tampilkan hanya data yang berkaitan dengan guru tersebut
        // Misalnya, ujian yang dibuat oleh guru ini
        // Asumsikan relasi Exam punya `guru_id` yang merujuk ke user

        $studentExams = \App\Models\StudentExam::whereHas('exam', function ($query) use ($user) {
                $query->where('guru_id', $user->id);
            })
            ->with('exam', 'siswa')
            ->latest('finished_at')
            ->get();
    } else {
        // Admin atau role lainnya, tampilkan semua data
        $studentExams = \App\Models\StudentExam::with('exam', 'siswa')
            ->latest('finished_at')
            ->get();
    }

    return view('siswa.exam.index', compact('studentExams'));
}



public function edit($id)
{
    $user = Auth::user();
    $studentExam = StudentExam::with(['exam.questions', 'siswa']) // hapus 'answers' disini
        ->findOrFail($id);

    if ($user->role === 'siswa') {
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        if ($studentExam->siswa_id !== $siswa->id) {
            abort(403, 'Akses ditolak.');
        }
    }

    // Ambil jawaban secara manual
    $answers = Answer::where('exam_id', $studentExam->exam_id)
        ->where('siswa_id', $studentExam->siswa_id)
        ->get()
        ->keyBy('question_id');

    $exam = $studentExam->exam;
    $questions = $exam->questions;

    // Decode pilihan ganda agar bisa ditampilkan
    $questions->transform(function ($question) {
        if (is_string($question->choices)) {
            $question->choices = json_decode($question->choices, true);
        }
        return $question;
    });

    return view('siswa.exam.edit', compact('studentExam', 'exam', 'questions', 'answers'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'score' => 'nullable|numeric|min:0|max:100',
        'manual_scores.*' => 'nullable|numeric|min:0|max:100',
    ]);

    $user = Auth::user();
    $studentExam = StudentExam::findOrFail($id);

    if ($user->role === 'siswa') {
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();
        if ($studentExam->siswa_id !== $siswa->id) {
            abort(403, 'Akses ditolak.');
        }
    }

    if ($user->role !== 'siswa' && $request->has('manual_scores')) {
        foreach ($request->manual_scores as $questionId => $score) {
            Answer::where([
                'exam_id' => $studentExam->exam_id,
                'siswa_id' => $studentExam->siswa_id,
                'question_id' => $questionId,
            ])->update([
                'score' => $score,
            ]);
        }
    }

    $total = Answer::where('exam_id', $studentExam->exam_id)
                ->where('siswa_id', $studentExam->siswa_id)
                ->whereNotNull('score')
                ->avg('score');

    $studentExam->update([
        'score' => round($total),
    ]);

    // Redirect ke /student-exams dengan pesan sukses
    return redirect('/student-exams')->with('success', 'Skor berhasil diperbarui.');
}

public function show($id)
{
    $user = Auth::user();
    $studentExam = StudentExam::with(['exam.questions', 'siswa'])->findOrFail($id);

    // Validasi akses jika siswa
    if ($user->role === 'siswa') {
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        if ($studentExam->siswa_id !== $siswa->id) {
            abort(403, 'Akses ditolak.');
        }
    }

    // Ambil jawaban siswa
    $answers = Answer::where('exam_id', $studentExam->exam_id)
        ->where('siswa_id', $studentExam->siswa_id)
        ->get()
        ->keyBy('question_id');

    $exam = $studentExam->exam;
    $questions = $exam->questions;

    // Decode pilihan ganda (jika masih dalam bentuk string)
    $questions->transform(function ($question) {
        if (is_string($question->choices)) {
            $decoded = json_decode($question->choices, true);
            $question->choices = is_array($decoded) ? $decoded : [];
        } elseif (is_null($question->choices)) {
            $question->choices = [];
        }
        return $question;
    });

    return view('siswa.exam.show', compact('studentExam', 'exam', 'questions', 'answers'));
}



   

}
