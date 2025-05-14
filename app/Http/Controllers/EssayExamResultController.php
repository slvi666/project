<?php

namespace App\Http\Controllers;

use App\Models\EssayExamResult;
use App\Models\Exam;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EssayExamResultController extends Controller
{
    public function index()
    {
        $results = EssayExamResult::with(['exam', 'siswa'])->latest()->paginate(10);
        return view('essay_exam_results.index', compact('results'));
    }

    public function create()
    {
        $exams = Exam::all();
        $siswas = Siswa::all();
        return view('essay_exam_results.create', compact('exams', 'siswas'));
    }

    public function store(Request $request)
    {
        // Validasi umum (boleh kosong di beberapa bagian)
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'siswa_id' => 'nullable|exists:siswa,id',
            'score' => 'nullable|integer',
            'feedback' => 'nullable|string',
            'question_option' => 'nullable|in:manual,upload',
            'answer_option' => 'nullable|in:manual,upload',
        ]);

        // Ambil nilai option dengan default 'manual'
        $questionOption = $request->question_option ?? null;
        $answerOption = $request->answer_option ?? null;

        // Validasi tambahan berdasarkan option (jika diisi)
        if ($questionOption === 'manual') {
            $request->validate(['question_text' => 'required|string']);
        } elseif ($questionOption === 'upload') {
            $request->validate(['question_pdf' => 'required|file|mimes:pdf|max:2048']);
        }

        if ($answerOption === 'manual') {
            $request->validate(['answer_text' => 'required|string']);
        } elseif ($answerOption === 'upload') {
            $request->validate(['answer_pdf' => 'required|file|mimes:pdf|max:2048']);
        }

        // Simpan konten soal
        $questionContent = null;
        if ($questionOption === 'upload' && $request->hasFile('question_pdf')) {
            $questionPdfPath = $request->file('question_pdf')->store('questions', 'public');
            $questionContent = '[PDF Uploaded] ' . $questionPdfPath;
        } elseif ($questionOption === 'manual') {
            $questionContent = $request->question_text;
        }

        // Simpan konten jawaban
        $answerContent = null;
        if ($answerOption === 'upload' && $request->hasFile('answer_pdf')) {
            $answerPdfPath = $request->file('answer_pdf')->store('answers', 'public');
            $answerContent = '[PDF Uploaded] ' . $answerPdfPath;
        } elseif ($answerOption === 'manual') {
            $answerContent = $request->answer_text;
        }

        EssayExamResult::create([
            'exam_id' => $request->exam_id,
            'siswa_id' => $request->siswa_id,
            'question_text' => $questionContent,
            'answer_text' => $answerContent,
            'score' => $request->score,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('essay_exam_results.index')
                         ->with('success', 'Data jawaban esai berhasil disimpan.');
    }

    public function show(EssayExamResult $essayExamResult)
    {
        return view('essay_exam_results.show', compact('essayExamResult'));
    }

    public function edit(EssayExamResult $essayExamResult)
    {
        $exams = Exam::all();
        $siswas = Siswa::all();
        return view('essay_exam_results.edit', compact('essayExamResult', 'exams', 'siswas'));
    }

    public function update(Request $request, EssayExamResult $essayExamResult)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'siswa_id' => 'nullable|exists:siswa,id',
            'score' => 'nullable|integer',
            'feedback' => 'nullable|string',
            'question_option' => 'nullable|in:manual,upload',
            'answer_option' => 'nullable|in:manual,upload',
        ]);

        $questionOption = $request->question_option ?? null;
        $answerOption = $request->answer_option ?? null;

        if ($questionOption === 'manual') {
            $request->validate(['question_text' => 'required|string']);
        } elseif ($questionOption === 'upload') {
            $request->validate(['question_pdf' => 'nullable|file|mimes:pdf|max:2048']);
        }

        if ($answerOption === 'manual') {
            $request->validate(['answer_text' => 'required|string']);
        } elseif ($answerOption === 'upload') {
            $request->validate(['answer_pdf' => 'nullable|file|mimes:pdf|max:2048']);
        }

        $questionContent = $essayExamResult->question_text;
        if ($questionOption === 'upload' && $request->hasFile('question_pdf')) {
            $questionPdfPath = $request->file('question_pdf')->store('questions', 'public');
            $questionContent = '[PDF Uploaded] ' . $questionPdfPath;
        } elseif ($questionOption === 'manual') {
            $questionContent = $request->question_text;
        }

        $answerContent = $essayExamResult->answer_text;
        if ($answerOption === 'upload' && $request->hasFile('answer_pdf')) {
            $answerPdfPath = $request->file('answer_pdf')->store('answers', 'public');
            $answerContent = '[PDF Uploaded] ' . $answerPdfPath;
        } elseif ($answerOption === 'manual') {
            $answerContent = $request->answer_text;
        }

        $essayExamResult->update([
            'exam_id' => $request->exam_id,
            'siswa_id' => $request->siswa_id,
            'question_text' => $questionContent,
            'answer_text' => $answerContent,
            'score' => $request->score,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('essay_exam_results.index')
                         ->with('success', 'Data jawaban esai berhasil diperbarui.');
    }

    public function destroy(EssayExamResult $essayExamResult)
    {
        $essayExamResult->delete();

        return redirect()->route('essay_exam_results.index')
                         ->with('success', 'Data jawaban esai berhasil dihapus.');
    }
}
