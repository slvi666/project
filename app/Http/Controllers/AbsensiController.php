<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use PDF; // pastikan ini di atas controller

class AbsensiController extends Controller
{
    public function index(Request $request, $id)
    {
        $mataPelajaran = MataPelajaran::with(['subject', 'guru'])->findOrFail($id);

        $query = Absensi::with(['siswa.user'])
            ->where('mata_pelajaran_id', $id);

        // Filter berdasarkan tanggal (opsional)
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter berdasarkan status (opsional)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensi = $query->get()->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y');
        });

        return view('absensi.index', compact('absensi', 'mataPelajaran'));
    }


    public function create($id)
    {
        $mataPelajaran = MataPelajaran::with(['subject', 'guru'])->findOrFail($id);

        // Ambil siswa berdasarkan siswa_ids yang terdaftar di mata pelajaran
        $siswaIds = $mataPelajaran->siswa_ids; // pastikan ini array (kalau stored as JSON)

        $siswa = Siswa::with('user')
            ->whereIn('id', $siswaIds)
            ->get();

        return view('absensi.create', compact('siswa', 'mataPelajaran'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d\TH:i',

            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'siswa_id' => 'required|array',
            'status' => 'required|array',
        ]);

        foreach ($request->siswa_id as $index => $siswaId) {
            Absensi::create([
                'tanggal' => $request->tanggal,
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'siswa_id' => $siswaId,
                'status' => $request->status[$index],
            ]);
        }

        return redirect()->route('absensi.index', $request->mata_pelajaran_id)->with('success', 'Data absensi berhasil disimpan.');
    }
    public function laporan(Request $request)
    {
        $mataPelajaran = MataPelajaran::with(['subject', 'guru'])->get(); // semua mata pelajaran

        // Ambil semua nama kelas unik dari relasi subject
        $kelasList = $mataPelajaran
        ->pluck('subject.class_name')
        ->filter()
        ->unique()
        ->sort()
        ->values();

        $query = Absensi::with(['siswa.user', 'mataPelajaran.subject', 'mataPelajaran.guru']);

        
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        if ($request->filled('kelas')) {
            $query->whereHas('mataPelajaran.subject', function ($q) use ($request) {
                $q->where('class_name', $request->kelas);
            });
        }
    

        $absensi = $query->orderBy('tanggal', 'desc')->get();

        return view('absensi.laporan_absensi', compact('absensi', 'mataPelajaran', 'kelasList'));
    }

    public function cetak(Request $request, $id)
    {
        $mataPelajaran = MataPelajaran::with(['subject', 'guru'])->findOrFail($id);

        $query = Absensi::with(['siswa.user'])
            ->where('mata_pelajaran_id', $id);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('nama_siswa')) {
            $query->whereHas('siswa.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->nama_siswa . '%');
            });
        }

        $absensi = $query->get()->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y');
        });

        $pdf = \PDF::loadView('absensi.cetak', compact('absensi', 'mataPelajaran'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('data-absensi.pdf');
    }
}
