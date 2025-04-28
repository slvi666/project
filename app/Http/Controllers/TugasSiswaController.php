<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Subject;
use App\Models\TugasSiswa;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class TugasSiswaController extends Controller
{
    public function index()
{
    if (auth()->user()->role_name === 'siswa') {
        $siswaId = auth()->user()->siswa->id;
        $tugas = TugasSiswa::with('siswa', 'guru', 'subject')
        ->where('siswa_id', $siswaId)
        ->latest()
        ->get();
        // dd($siswaId);   
    } elseif (auth()->user()->role_name === 'guru') {
        $guruId = auth()->user()->guru->id;
        $tugas = TugasSiswa::with('siswa', 'guru', 'subject')
            ->where('guru_id', $guruId)
            ->latest()
            ->get();
    } else {
        $tugas = TugasSiswa::with('siswa', 'guru', 'subject')->latest()->get();
    }
    // dd($tugas);

    return view('tugas.index', compact('tugas'));
}

public function create()
{
    $siswa = Siswa::all();
    $guru = Guru::all();
    $subject = Subject::all();
    $authGuruId = Auth::user()->guru_id; // Assuming the user has a `guru_id` column

    return view('tugas.create', compact('siswa', 'guru', 'subject', 'authGuruId'));
}


    public function store(Request $request)
{
    $request->validate([
        'siswa_id' => 'required|array', // Memastikan siswa_id adalah array
        'siswa_id.*' => 'exists:siswa,id', // Validasi ID siswa yang dipilih ada di database
        'guru_id' => 'required',
        'subject_id' => 'required',
        'judul_tugas' => 'required',
        'tanggal_diberikan' => 'required|date',
        'deadline' => 'required|date',
        'file_soal' => 'nullable|file|mimes:pdf,doc,docx',
        'nilai_tugas' => 'nullable|integer',
    ]);

    $data = $request->except('siswa_id'); // Menyimpan data selain siswa_id

    if ($request->hasFile('file_soal')) {
        $data['file_soal'] = $request->file('file_soal')->store('tugas', 'public');
    }

    foreach ($request->siswa_id as $siswaId) {
        // Simpan tugas untuk setiap siswa
        TugasSiswa::create(array_merge($data, ['siswa_id' => $siswaId]));
    }

    return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan');
}


    public function edit($id)
    {
        $tugas = TugasSiswa::findOrFail($id);
        $siswa = Siswa::all();
        $guru = Guru::all();
        $subject = Subject::all();
        return view('tugas.edit', compact('tugas', 'siswa', 'guru', 'subject'));
    }

    public function update(Request $request, $id)
    {
        
        $tugas = TugasSiswa::findOrFail($id);

        $request->validate([
            'judul_tugas' => 'required',
            'tanggal_diberikan' => 'required|date',
            'deadline' => 'required|date',
            'file_soal' => 'nullable|file|mimes:pdf,doc,docx',
            'file_jawaban' => 'nullable|file|mimes:pdf,doc,docx',
            'nilai_tugas' => 'nullable|integer', // Tambahan validasi nilai
        ]);

        $data = $request->all();

        if ($request->hasFile('file_soal')) {
            if ($tugas->file_soal) {
                Storage::disk('public')->delete($tugas->file_soal);
            }
            $data['file_soal'] = $request->file('file_soal')->store('tugas', 'public');
        }

        // Cek deadline sebelum mengizinkan upload jawaban
        $today = Carbon::now()->toDateString();

        if ($request->hasFile('file_jawaban')) {
            if ($today > $tugas->deadline) {
                return redirect()->back()->with('error', 'Deadline telah lewat. Upload jawaban tidak diperbolehkan.');
            }

            if ($tugas->file_jawaban) {
                Storage::disk('public')->delete($tugas->file_jawaban);
            }

            $data['file_jawaban'] = $request->file('file_jawaban')->store('tugas', 'public');
            $data['status'] = 'sudah_dikumpulkan';
        }

        $tugas->update($data);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui');
    }


    public function destroy($id)
    {
        $tugas = TugasSiswa::findOrFail($id);

        if ($tugas->file_soal) {
            Storage::disk('public')->delete($tugas->file_soal);
        }

        if ($tugas->file_jawaban) {
            Storage::disk('public')->delete($tugas->file_jawaban);
        }

        $tugas->delete();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus');
    }

    public function downloadSoal($id)
    {
        $tugas = TugasSiswa::findOrFail($id);
        return Storage::disk('public')->download($tugas->file_soal);
    }

    public function downloadJawaban($id)
    {
        $tugas = TugasSiswa::findOrFail($id);
        return Storage::disk('public')->download($tugas->file_jawaban);
    }

    public function show($id)
{
    // Ambil tugas berdasarkan ID
    $tugas = TugasSiswa::with(['siswa.user', 'guru', 'subject'])->findOrFail($id);

    // Kembalikan ke view 'tugas.show' dengan data tugas
    return view('tugas.show', compact('tugas'));
}
}
