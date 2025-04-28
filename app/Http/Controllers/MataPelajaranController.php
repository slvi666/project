<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Subject;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MataPelajaranController extends Controller
{
    // Menampilkan semua data mata pelajaran
    public function index()
    {
        $user = Auth::user();

        if ($user->role_name === 'Admin' || $user->role_name === 'siswa') {
            // Admin dan siswa bisa lihat semua data
            $data = MataPelajaran::with(['subject', 'guru'])->get();
        } elseif ($user->role_name === 'guru') {
            // Guru hanya lihat data pelajaran yang dia ajar
            $data = MataPelajaran::with(['subject', 'guru'])
                ->where('guru_id', $user->id)
                ->get();
        } else {
            // Role lain tidak bisa lihat apa pun
            $data = collect();
        }

        return view('mata_pelajaran.index', compact('data'));
    }


    // Form tambah data
    public function create()
    {
        $subjects = Subject::all();
        $gurus = User::where('role_name', 'guru')->get();
        $siswa = Siswa::all();

        return view('mata_pelajaran.create', compact('subjects', 'gurus', 'siswa'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'guru_id' => 'required|exists:users,id',
            'siswa_ids' => 'required|array',
            'waktu_mulai' => 'required',
            'waktu_berakhir' => 'required',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        ]);

        // Cek apakah ada jadwal bentrok
    $bentrok = MataPelajaran::where('hari', $request->hari)
    ->where('guru_id', $request->guru_id)
    ->where(function($query) use ($request) {
        $query->whereBetween('waktu_mulai', [$request->waktu_mulai, $request->waktu_berakhir])
              ->orWhereBetween('waktu_berakhir', [$request->waktu_mulai, $request->waktu_berakhir])
              ->orWhere(function($query) use ($request) {
                  $query->where('waktu_mulai', '<=', $request->waktu_mulai)
                        ->where('waktu_berakhir', '>=', $request->waktu_berakhir);
              });
    })
    ->exists();
    // dd($bentrok);


if ($bentrok) {
    return back()->withErrors(['msg' => 'Jadwal bentrok dengan jadwal lain.'])->withInput();
}

        MataPelajaran::create([
            'subject_id' => $request->subject_id,
            'guru_id' => $request->guru_id,
            'siswa_ids' => $request->siswa_ids,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_berakhir' => $request->waktu_berakhir,
            'hari' => $request->hari,
        ]);

        return redirect()->route('mata-pelajaran.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // Form edit
    public function edit($id)
    {
        $data = MataPelajaran::findOrFail($id);
        $subjects = Subject::all();
        $gurus = User::where('role_name', 'guru')->get();
        $siswa = Siswa::all();

        return view('mata_pelajaran.edit', compact('data', 'subjects', 'gurus', 'siswa'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'guru_id' => 'required|exists:users,id',
            'siswa_ids' => 'required|array',
            'waktu_mulai' => 'required',
            'waktu_berakhir' => 'required',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        ]);
        $bentrok = MataPelajaran::where('hari', $request->hari)
        ->where('guru_id', $request->guru_id)
        ->where(function($query) use ($request) {
            $query->whereBetween('waktu_mulai', [$request->waktu_mulai, $request->waktu_berakhir])
                  ->orWhereBetween('waktu_berakhir', [$request->waktu_mulai, $request->waktu_berakhir])
                  ->orWhere(function($query) use ($request) {
                      $query->where('waktu_mulai', '<=', $request->waktu_mulai)
                            ->where('waktu_berakhir', '>=', $request->waktu_berakhir);
                  });
        })
        ->exists();
        // dd($bentrok);
    
    
    if ($bentrok) {
        return back()->withErrors(['msg' => 'Jadwal bentrok dengan jadwal lain.'])->withInput();
    }

        $data = MataPelajaran::findOrFail($id);
        $data->update([
            'subject_id' => $request->subject_id,
            'guru_id' => $request->guru_id,
            'siswa_ids' => $request->siswa_ids,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_berakhir' => $request->waktu_berakhir,
            'hari' => $request->hari,
        ]);

        return redirect()->route('mata-pelajaran.index')->with('success', 'Data berhasil diupdate!');
    }

    // Hapus data
    public function destroy($id)
    {
        MataPelajaran::destroy($id);
        return redirect()->route('mata-pelajaran.index')->with('success', 'Data berhasil dihapus!');
    }
}
