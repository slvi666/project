<?php

namespace App\Http\Controllers;

use App\Models\StudentExam;
use App\Models\Siswa;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\Answer;

class StudentExamController extends Controller
{
    /**
     * Menampilkan daftar student exams.
     */
    public function index()
    {
        // Menampilkan semua data student exams
        $studentExams = StudentExam::with(['siswa', 'exam'])->get();
        return view('student_exams.index', compact('studentExams'));
    }

    /**
     * Menampilkan form untuk menambah student exam baru.
     */
public function create()
{
    // Ambil semua data siswa dan ujian untuk dipilih
    $siswa = Siswa::all();
    $exams = Exam::all();

    return view('student_exams.create', compact('siswa', 'exams'));
}



    /**
     * Menyimpan student exam baru.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'exam_id' => 'required|exists:exams,id',
            'started_at' => 'required|date',
            'finished_at' => 'nullable|date|after_or_equal:started_at',
            'score' => 'nullable|integer|min:0',
        ]);

        // Menyimpan data baru ke database
        StudentExam::create([
            'siswa_id' => $request->siswa_id,
            'exam_id' => $request->exam_id,
            'started_at' => $request->started_at,
            'finished_at' => $request->finished_at,
            'score' => $request->score,
        ]);

        return redirect()->route('student_exams.index')->with('success', 'Student exam added successfully!');
    }

    /**
     * Menampilkan form untuk mengedit student exam.
     */
    public function edit($id)
    {
        $studentExam = StudentExam::findOrFail($id);
        $siswa = Siswa::all();
        $exams = Exam::all();

        return view('student_exams.edit', compact('studentExam', 'siswa', 'exams'));
    }

    /**
     * Memperbarui student exam yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'exam_id' => 'required|exists:exams,id',
            'started_at' => 'required|date',
            'finished_at' => 'nullable|date|after_or_equal:started_at',
            'score' => 'nullable|integer|min:0',
        ]);

        // Menyimpan perubahan data ke database
        $studentExam = StudentExam::findOrFail($id);
        $studentExam->update([
            'siswa_id' => $request->siswa_id,
            'exam_id' => $request->exam_id,
            'started_at' => $request->started_at,
            'finished_at' => $request->finished_at,
            'score' => $request->score,
        ]);

        return redirect()->route('student_exams.index')->with('success', 'Student exam updated successfully!');
    }

    /**
     * Menghapus student exam.
     */
    public function destroy($id)
    {
        $studentExam = StudentExam::findOrFail($id);
        $studentExam->delete();

        return redirect()->route('student_exams.index')->with('success', 'Student exam deleted successfully!');
    }

    /**
     * Menampilkan detail dari student exam.
     */
    public function show($id)
    {
        $studentExam = StudentExam::with(['siswa', 'exam'])->findOrFail($id);
        return view('student_exams.show', compact('studentExam'));
    }
    public function calculateScore($studentExamId)
{
    $answers = Answer::where('student_exam_id', $studentExamId)->get();

    $totalScore = $answers->sum('score');
    $jumlahSoal = $answers->count();
    $finalScore = $jumlahSoal > 0 ? intval($totalScore / $jumlahSoal) : 0;

    $studentExam = StudentExam::find($studentExamId);
    $studentExam->score = $finalScore;
    $studentExam->save();

    return redirect()->back()->with('success', 'Skor berhasil dihitung.');
}

}
