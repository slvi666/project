<?php

namespace App\Http\Controllers;

use App\Models\SeleksiBerkas;
use App\Models\FormulirPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SeleksiBerkasController extends Controller
{
    // Menampilkan semua data seleksi berkas
    public function index()
    {
        $user = Auth::user();

        $query = SeleksiBerkas::with(['user', 'formulirPendaftaran'])
            ->orderBy('created_at', 'desc');

        if ($user->role_name === 'calon_siswa') {
            $query->where('user_id', $user->id); // hanya data milik user ini
        }

        $data = $query->paginate(10);
    
        return view('SeleksiBerkas.index', compact('data'));
    }
    

    // Menampilkan halaman tambah data seleksi berkas (ID otomatis dari user login)
    public function create()
    {
        $user = Auth::user();
        $formulir = FormulirPendaftaran::where('user_id', $user->id)->first();

        if (!$formulir) {
            return redirect()->route('seleksi-berkas.index')->with('error', 'Anda belum mengisi formulir pendaftaran.');
        }

        return view('SeleksiBerkas.create', compact('user', 'formulir'));
    }

    // Menampilkan detail seleksi berkas
    public function show($id)
    {
        $seleksiBerkas = SeleksiBerkas::with(['user', 'formulirPendaftaran'])->findOrFail($id);
        return view('SeleksiBerkas.show', compact('seleksiBerkas'));
    }

    // Menyimpan data seleksi berkas
    public function store(Request $request)
    {
        $user = Auth::user();
        $formulir = FormulirPendaftaran::where('user_id', $user->id)->first();

        if (!$formulir) {
            return redirect()->route('seleksi-berkas.index')->with('error', 'Anda belum mengisi formulir pendaftaran.');
        }

        $request->validate([
            'poto_ktp_orang_tua' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'kartu_keluarga' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'akte_kelahiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'surat_kelulusan' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'raport' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'kis_kip' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $data = new SeleksiBerkas();
        $data->user_id = $user->id;
        $data->formulir_pendaftaran_id = $formulir->id;

        foreach (['poto_ktp_orang_tua', 'kartu_keluarga', 'akte_kelahiran', 'surat_kelulusan', 'raport', 'kis_kip', 'ijazah'] as $field) {
            if ($request->hasFile($field)) {
                $data->$field = $request->file($field)->store('seleksi_berkas','public');
            }
        }

        $data->save();

        return redirect()->route('seleksi-berkas.index')->with('success', 'Data berhasil disimpan');
    }

    // Menampilkan halaman edit seleksi berkas
    public function edit($id)
    {
        $seleksiBerkas = SeleksiBerkas::findOrFail($id);
        return view('SeleksiBerkas.edit', compact('seleksiBerkas',));
    }

    // Mengupdate data seleksi berkas
// Mengupdate data seleksi berkas
// Mengupdate data seleksi berkas
public function update(Request $request, SeleksiBerkas $seleksiBerkas)
{
    // Validasi data yang dikirim
    $request->validate([
        'formulir_pendaftaran_id' => 'required|exists:formulir_pendaftaran,id',
    ]);

    // Periksa file yang diupload dan update
    foreach (['poto_ktp_orang_tua', 'kartu_keluarga', 'akte_kelahiran', 'surat_kelulusan', 'raport', 'kis_kip', 'ijazah'] as $field) {
        if ($request->hasFile($field)) {
            // Hapus file lama jika ada
            if ($seleksiBerkas->$field) {
                Storage::delete($seleksiBerkas->$field);
            }
            // Simpan file baru
            $seleksiBerkas->$field = $request->file($field)->store('seleksi_berkas', 'public');

        }
    }

    // Pastikan user_id diperbarui
    $seleksiBerkas->user_id = auth()->id();  // Set user_id yang sedang login
    $seleksiBerkas->formulir_pendaftaran_id = $request->formulir_pendaftaran_id;

    // Simpan perubahan
    $seleksiBerkas->save();

    // Redirect kembali dengan pesan sukses
    return redirect()->route('seleksi-berkas.index')->with('success', 'Data berhasil diperbarui');
}


    // Menghapus data seleksi berkas
    public function destroy(SeleksiBerkas $seleksiBerkas)
    {
        foreach (['poto_ktp_orang_tua', 'kartu_keluarga', 'akte_kelahiran', 'surat_kelulusan', 'raport', 'kis_kip', 'ijazah'] as $field) {
            if ($seleksiBerkas->$field) {
                Storage::delete($seleksiBerkas->$field);
            }
        }

        $seleksiBerkas->delete();

        return redirect()->route('seleksi-berkas.index')->with('success', 'Data berhasil dihapus');
    }
}
