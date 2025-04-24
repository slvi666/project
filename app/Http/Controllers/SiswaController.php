<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_name === 'siswa') {
            // Ambil data siswa yang terkait dengan user yang sedang login
            $siswa = Siswa::with('user', 'subject')->where('user_id', auth()->user()->id)->get();
        } else {
            // Admin bisa lihat semua data siswa
            $siswa = Siswa::with('user', 'subject')->get();
        }

        return view('profil_siswa.index', compact('siswa'));
    }


    public function create()
    {
        if (auth()->user()->role_name === 'siswa') {
            // Hanya user yang sedang login
            $users = User::where('id', auth()->user()->id)->get();
        } else {
            // Semua user yang role-nya siswa
            $users = User::where('role_name', 'siswa')->get();
        }

        $subjects = Subject::all();

        return view('profil_siswa.create', compact('users', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'nisn' => 'required|unique:siswa,nisn',
            'poto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $potoPath = $request->hasFile('poto') ? $request->file('poto')->store('potos', 'public') : null;

        Siswa::create([
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
            'nisn' => $request->nisn,
            'poto' => $potoPath,
        ]);

        return redirect()->route('profil_siswa.index')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function show(Siswa $siswa)
    {
        return view('profil_siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $users = User::where('role_name', 'siswa')->get();
        $subjects = Subject::all();
        return view('profil_siswa.edit', compact('siswa', 'users', 'subjects'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'nisn' => 'required|unique:siswa,nisn,' . $siswa->id,
            'poto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('poto')) {
            if ($siswa->poto) {
                Storage::disk('public')->delete($siswa->poto);
            }
            $siswa->poto = $request->file('poto')->store('potos', 'public');
        }

        $siswa->update([
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
            'nisn' => $request->nisn,
            'poto' => $siswa->poto,
        ]);

        return redirect()->route('profil_siswa.index')->with('success', 'Siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->poto) {
            Storage::disk('public')->delete($siswa->poto);
        }

        $siswa->delete();
        return redirect()->route('profil_siswa.index')->with('success', 'Siswa berhasil dihapus!');
    }
}
