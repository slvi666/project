<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\StudentExam;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    // Tampilkan semua jawaban (bisa difilter per student_exam_id)
    public function index(Request $request)
    {
        $answers = $request->has('student_exam_id')
            ? Answer::where('student_exam_id', $request->student_exam_id)->get()
            : Answer::all();

        return view('answers.index', compact('answers'));
    }

    // Form tambah jawaban
public function create()
{
    $studentExams = StudentExam::with(['siswa', 'exam'])->get();
    $questions = Question::all();
    return view('answers.create', compact('studentExams', 'questions'));
}


    // Simpan jawaban
    public function store(Request $request)
    {
        $request->validate([
            'student_exam_id' => 'required|exists:student_exams,id',
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required|string',
            'score' => 'nullable|integer',
        ]);

        $question = Question::find($request->question_id);

        Answer::create([
            'student_exam_id' => $request->student_exam_id,
            'question_id' => $request->question_id,
            'answer_text' => $request->answer_text,
            'score' => $question->type === 'essay' ? $request->score : null,
        ]);

        return redirect()->route('answers.index')->with('success', 'Jawaban berhasil disimpan.');
    }

    // Tampilkan satu jawaban
    public function show($id)
    {
        $answer = Answer::findOrFail($id);
        return view('answers.show', compact('answer'));
    }

    // Form edit jawaban
    public function edit($id)
    {
        $answer = Answer::findOrFail($id);
        $studentExams = StudentExam::all();
        $questions = Question::all();
        return view('answers.edit', compact('answer', 'studentExams', 'questions'));
    }

    // Update jawaban
    public function update(Request $request, $id)
    {
        $request->validate([
            'answer_text' => 'nullable|string',
            'score' => 'nullable|integer',
        ]);

        $answer = Answer::findOrFail($id);
        $question = Question::find($answer->question_id);

        if ($request->filled('answer_text')) {
            $answer->answer_text = $request->answer_text;
        }

        if ($question->type === 'essay') {
            $answer->score = $request->score;
        }

        $answer->save();

        return redirect()->route('answers.index')->with('success', 'Jawaban berhasil diperbarui.');
    }

    // Hapus jawaban
    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();

        return redirect()->route('answers.index')->with('success', 'Jawaban berhasil dihapus.');
    }

    // Penilaian otomatis untuk soal PG
    public function autoGrade($id)
    {
        $answer = Answer::findOrFail($id);
        $question = Question::findOrFail($answer->question_id);

        if ($question->type === 'PG') {
            $correctAnswer = $question->correct_answer;
            $answer->score = ($answer->answer_text === $correctAnswer) ? 100 : 0;
            $answer->save();
        }

        return redirect()->route('answers.index')->with('success', 'Penilaian otomatis selesai.');
    }
}
