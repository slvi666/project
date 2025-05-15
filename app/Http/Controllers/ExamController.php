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
    // Ambil daftar kelas unik untuk dropdown filter (misalnya untuk admin/guru)
    $kelasList = Subject::select('class_name')->distinct()->orderBy('class_name')->pluck('class_name');

    // Query dasar ujian dengan relasi subject
    $query = Exam::with('subject');

    // Cek peran user yang login
    if (auth()->user()->role_name === 'siswa') {
        // Ambil data siswa berdasarkan user_id
        $siswa = \App\Models\Siswa::where('user_id', auth()->id())->first();

        // Ambil class_name dari relasi subject (misalnya siswa hanya bisa lihat exam untuk kelasnya)
        $className = optional($siswa->subject)->class_name;

        // Filter berdasarkan class_name siswa
        $query->whereHas('subject', function ($q) use ($className) {
            $q->where('class_name', $className);
        });
    } elseif (request('kelas')) {
        // Jika ada request filter kelas (biasanya dari admin/guru)
        $query->whereHas('subject', function ($q) {
            $q->where('class_name', request('kelas'));
        });
    }

    // Ambil data ujian yang sudah difilter
    $exams = $query->latest()->get();

    // Kirim data ke view
    return view('exams.index', compact('exams', 'kelasList'));
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
