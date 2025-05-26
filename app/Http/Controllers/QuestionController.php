<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Exam;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionImport;

class QuestionController extends Controller
{
    // Menampilkan daftar soal berdasarkan exam
   public function index($examId)
{
    $exam = Exam::findOrFail($examId);
    $questions = $exam->questions;

    // Tambahan: cek apakah ada soal pilihan ganda
    $hasMultipleChoice = $questions->contains(function ($question) {
        return in_array($question->type, ['multiple', 'pilihan_ganda']);
    });

    return view('questions.index', compact('exam', 'questions', 'hasMultipleChoice'));
}

    // Menampilkan form untuk membuat soal baru
    public function create($examId)
    {
        $exam = Exam::findOrFail($examId);
        return view('questions.create', compact('exam'));
    }

    // Menyimpan soal baru
    public function store(Request $request, $examId)
    {
        $request->validate([
            'question_text' => 'required',
            'type' => 'required',
            'choices' => 'nullable|json',
            'correct_answer' => 'nullable|string',
        ]);

        $exam = Exam::findOrFail($examId);

        Question::create([
            'exam_id' => $exam->id,
            'question_text' => $request->question_text,
            'type' => $exam->question_type,
           'choices' => $request->choices ? $request->choices : null,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('questions.index', $exam->id)->with('success', 'Soal berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit soal
    public function edit($examId, $questionId)
    {
        $exam = Exam::findOrFail($examId);
        $question = Question::findOrFail($questionId);

        return view('questions.edit', compact('exam', 'question'));
    }

    // Mengupdate soal yang ada
    public function update(Request $request, $examId, $questionId)
    {
        $request->validate([
            'question_text' => 'required',
            'type' => 'required',
            'choices' => 'nullable|json',
            'correct_answer' => 'nullable|string',
        ]);

        $question = Question::findOrFail($questionId);

        $question->update([
            'question_text' => $request->question_text,
            'type' => $request->type,
            'choices' => $request->choices ? $request->choices : null,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('questions.index', $examId)->with('success', 'Soal berhasil diperbarui.');
    }

    // Menghapus soal
    public function destroy($examId, $questionId)
    {
        $question = Question::findOrFail($questionId);
        $question->delete();

        return redirect()->route('questions.index', $examId)->with('success', 'Soal berhasil dihapus.');
    }

    // Import soal dari file Excel
public function importExcel(Request $request, $exam_id)
{
    $request->validate([
        'excel_file' => 'required|file|mimes:xlsx,xls'
    ]);

    $exam = Exam::findOrFail($exam_id);

    try {
        Excel::import(new QuestionImport($exam), $request->file('excel_file'));
        return redirect()->route('questions.index', $exam->id)->with('success', 'Soal berhasil diimpor.');
    } catch (\Exception $e) {
        \Log::error('Gagal impor soal: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Gagal impor soal: ' . $e->getMessage());
    }
}

}
