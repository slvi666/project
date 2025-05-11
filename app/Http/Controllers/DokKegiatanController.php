<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokKegiatan;
use Illuminate\Support\Facades\Storage;

class DokKegiatanController extends Controller
{
    // Menampilkan semua dokumen kegiatan
    public function index()
    {
        $dokKegiatan = DokKegiatan::all();
        return view('dok_kegiatan.index', compact('dokKegiatan'));
    }

    // Menampilkan form upload dokumen
    public function create()
    {
        return view('dok_kegiatan.create');
    }

    // Menyimpan dokumen ke database dan storage
    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'path_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menyimpan file ke storage
        $path = $request->file('path_file')->store('public/dok_kegiatan');

        DokKegiatan::create([
            'nama_dokumen' => $request->nama_dokumen,
            'deskripsi' => $request->deskripsi,
            'path_file' => str_replace('public/', 'storage/', $path), // Path untuk akses publik
        ]);

        return redirect()->route('dok_kegiatan.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    // Menampilkan detail dokumen
    public function show(DokKegiatan $dokKegiatan)
    {
        return view('dok_kegiatan.show', compact('dokKegiatan'));
    }

    // Menampilkan form edit dokumen
    public function edit(DokKegiatan $dokKegiatan)
    {
        return view('dok_kegiatan.edit', compact('dokKegiatan'));
    }

    // Mengupdate dokumen
    public function update(Request $request, DokKegiatan $dokKegiatan)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'path_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('path_file')) {
            // Hapus file lama
            Storage::delete(str_replace('storage/', 'public/', $dokKegiatan->path_file));

            // Simpan file baru
            $path = $request->file('path_file')->store('public/dok_kegiatan');
            $dokKegiatan->path_file = str_replace('public/', 'storage/', $path);
        }

        $dokKegiatan->update([
            'nama_dokumen' => $request->nama_dokumen,
            'deskripsi' => $request->deskripsi,
            'path_file' => $dokKegiatan->path_file,
        ]);

        return redirect()->route('dok_kegiatan.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    // Menghapus dokumen
    public function destroy(DokKegiatan $dokKegiatan)
    {
        Storage::delete(str_replace('storage/', 'public/', $dokKegiatan->path_file));
        $dokKegiatan->delete();

        return redirect()->route('dok_kegiatan.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
