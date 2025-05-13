<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    // Menampilkan daftar ujian
    public function index()
    {
        $exams = Exam::with('subject')->get(); // Mengambil semua ujian beserta data mata pelajaran
        return view('exams.index', compact('exams'));
    }

    // Menampilkan form untuk membuat ujian baru
public function create()
{
    $subjects = Subject::all(); // Mengambil semua mata pelajaran
    // dd($subjects); // Memastikan data sudah diambil dengan benar
    return view('exams.create', compact('subjects'));
}


    // Menyimpan ujian baru ke database
public function store(Request $request)
{
    $request->validate([
        'subject_id' => 'required|exists:subjects,id',
        'exam_title' => 'required|string|max:255',
        'question_type' => 'required|in:pilihan_ganda,esai,campuran',
        'duration' => 'required|integer',
        'start_time' => 'nullable|date',
        'end_time' => 'nullable|date',
    ]);

    Exam::create([
        'subject_id' => $request->subject_id,
        'exam_title' => $request->exam_title,
        'question_type' => $request->question_type,
        'duration' => $request->duration,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
    ]);

    return redirect()->route('exams.index')->with('success', 'Ujian berhasil dibuat');
}


    // Menampilkan detail ujian
    public function show($id)
    {
        $exam = Exam::with('subject')->findOrFail($id);
        return view('exams.show', compact('exam'));
    }

    // Menampilkan form untuk mengedit ujian
    public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        $subjects = Subject::all(); // Mengambil semua mata pelajaran
        return view('exams.edit', compact('exam', 'subjects'));
    }

    // Memperbarui ujian
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'exam_title' => 'required|string|max:255',
            'question_type' => 'required|in:pilihan_ganda,esai,campuran',
            'duration' => 'required|integer',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date',
        ]);

        $exam = Exam::findOrFail($id);
        $exam->update([
            'subject_id' => $request->subject_id,
            'exam_title' => $request->exam_title,
            'question_type' => $request->question_type,
            'duration' => $request->duration,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('exams.index')->with('success', 'Ujian berhasil diperbarui');
    }

    // Menghapus ujian
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Ujian berhasil dihapus');
    }
}
