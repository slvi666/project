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
    $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

    $studentExams = $siswa->studentExams()
        ->with('exam')
        ->latest('finished_at')
        ->get();

    return view('siswa.exam.index', compact('studentExams'));
}


    public function edit($id)
{
    $user = Auth::user();
    $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

    $studentExam = StudentExam::with('exam')
        ->where('id', $id)
        ->where('siswa_id', $siswa->id)
        ->firstOrFail();

    return view('siswa.exam.edit', compact('studentExam'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'score' => 'required|numeric|min:0|max:100',
    ]);

    $user = Auth::user();
    $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

    $studentExam = StudentExam::where('id', $id)
        ->where('siswa_id', $siswa->id)
        ->firstOrFail();

    $studentExam->update([
        'score' => $request->score,
    ]);

return redirect('/student-exams')->with('success', 'Skor berhasil diperbarui.');


}


   

}
