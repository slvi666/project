<?php
namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // Menampilkan daftar mata pelajaran
    public function index()
    {
        $subjects = Subject::paginate(10); // Menggunakan paginasi
        return view('subjeck.index', compact('subjects'));
    }

    // Menampilkan form tambah mata pelajaran
    public function create()
    {
        return view('subjeck.create');
    }

    // Menyimpan mata pelajaran baru
    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'subject_name' => 'required|string|max:255',
        ]);

        Subject::create($request->all());
        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    // Menampilkan detail mata pelajaran
    public function show($id)
    {
        $subject = Subject::findOrFail($id);
        return view('subjeck.show', compact('subject'));
    }

    // Menampilkan form edit mata pelajaran
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('subjeck.edit', compact('subject'));
    }

    // Mengupdate data mata pelajaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'subject_name' => 'required|string|max:255',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update($request->all());

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil diperbarui');
    }

    // Menghapus mata pelajaran
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil dihapus');
    }
}