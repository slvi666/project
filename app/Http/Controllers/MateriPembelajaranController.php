<?php

namespace App\Http\Controllers;

use App\Models\MateriPembelajaran;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriPembelajaranController extends Controller
{
    // public function index()
    // {
    //     $materi = MateriPembelajaran::with('guru', 'subject')->latest()->get();
    //     return view('MateriPembelajaran.index', compact('materi'));
    // }

    public function index()
    {
        // Ambil daftar kelas unik untuk dropdown filter
        $kelasList = Subject::select('class_name')->distinct()->orderBy('class_name')->pluck('class_name');
        
        // Query dasar
        $query = MateriPembelajaran::with(['guru', 'subject']);
        
        // Filter berdasarkan kelas jika dipilih
        if(request('kelas')) {
            $query->whereHas('subject', function($q) {
                $q->where('class_name', request('kelas'));
            });
        }
        
        $materi = $query->latest()->get();
        
        return view('MateriPembelajaran.index', compact('materi', 'kelasList'));
    }

    public function create()
    {
        $guru = User::where('role_name', 'guru')->get();
        $subject = Subject::all();
        return view('MateriPembelajaran.create', compact('guru', 'subject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'file' => 'required|mimes:pdf|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $filePath = $request->file('file')->store('materi_pembelajaran', 'public');

        MateriPembelajaran::create([
            'guru_id' => $request->guru_id,
            'subject_id' => $request->subject_id,
            'file' => $filePath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $materi = MateriPembelajaran::with('guru', 'subject')->findOrFail($id);
        return view('MateriPembelajaran.show', compact('materi'));
    }

    public function edit($id)
    {
        $materi = MateriPembelajaran::findOrFail($id);
        $guru = User::where('role_name', 'guru')->get();
        $subject = Subject::all();

        return view('MateriPembelajaran.edit', compact('materi', 'guru', 'subject'));
    }

    public function update(Request $request, $id)
    {
        $materi = MateriPembelajaran::findOrFail($id);

        $request->validate([
            'guru_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'file' => 'nullable|mimes:pdf|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($materi->file && Storage::disk('public')->exists($materi->file)) {
                Storage::disk('public')->delete($materi->file);
            }

            $filePath = $request->file('file')->store('materi_pembelajaran', 'public');
            $materi->file = $filePath;
        }

        $materi->guru_id = $request->guru_id;
        $materi->subject_id = $request->subject_id;
        $materi->deskripsi = $request->deskripsi;
        $materi->save();

        return redirect()->route('materi.index')->with('success', 'Materi berhasil diupdate.');
    }

    public function destroy($id)
    {
        $materi = MateriPembelajaran::findOrFail($id);

        if ($materi->file && Storage::disk('public')->exists($materi->file)) {
            Storage::disk('public')->delete($materi->file);
        }

        $materi->delete();

        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus.');
    }
}
