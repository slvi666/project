<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Exam;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Menampilkan daftar soal berdasarkan exam
    public function index($examId)
    {
        $exam = Exam::findOrFail($examId);  // Menemukan ujian berdasarkan ID
        $questions = $exam->questions; // Mendapatkan semua soal yang terkait dengan ujian ini

        return view('questions.index', compact('exam', 'questions'));
    }

    // Menampilkan form untuk membuat soal baru
    public function create($examId)
    {
        $exam = Exam::findOrFail($examId); // Menemukan ujian berdasarkan ID
        return view('questions.create', compact('exam'));
    }

    // Menyimpan soal baru
    public function store(Request $request, $examId)
    {
        $request->validate([
            'question_text' => 'required',
            'type' => 'required',
            'choices' => 'nullable|json', // Validasi untuk kolom choices, jika tipe soal pilihan ganda
            'correct_answer' => 'nullable|string', // Validasi untuk jawaban yang benar, jika tipe soal pilihan ganda
        ]);

        $exam = Exam::findOrFail($examId);

        Question::create([
            'exam_id' => $exam->id,
            'question_text' => $request->question_text,
            'type' => $request->type,
            'choices' => $request->choices ? json_encode($request->choices) : null,
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

        $exam = Exam::findOrFail($examId);
        $question = Question::findOrFail($questionId);

        $question->update([
            'question_text' => $request->question_text,
            'type' => $request->type,
            'choices' => $request->choices ? json_encode($request->choices) : null,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('questions.index', $exam->id)->with('success', 'Soal berhasil diperbarui.');
    }

    // Menghapus soal
    public function destroy($examId, $questionId)
    {
        $exam = Exam::findOrFail($examId);
        $question = Question::findOrFail($questionId);

        $question->delete();

        return redirect()->route('questions.index', $exam->id)->with('success', 'Soal berhasil dihapus.');
    }
}
