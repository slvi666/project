<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku.
     */
    public function index()
    {
        $buku = Buku::latest()->get();
        return view('buku.index', compact('buku'));
    }

    /**
     * Menampilkan form tambah buku.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Menyimpan buku baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cover_buku' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori' => 'required|in:' . implode(',', Buku::getKategoriList()),
            'file_buku' => 'required|mimes:pdf|max:5120',
        ]);

        // Upload cover buku
        $coverPath = $request->file('cover_buku')->store('covers', 'public');

        // Upload file buku (PDF)
        $filePath = $request->file('file_buku')->store('books', 'public');

        Buku::create([
            'cover_buku' => $coverPath,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'file_buku' => $filePath,
            'views' => 0,
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail buku.
     */
    public function show(Buku $buku)
    {
        // Tambah jumlah views saat buku dikunjungi
        $buku->increment('views');

        return view('buku.show', compact('buku'));
    }

    /**
     * Menampilkan form edit buku.
     */
    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    /**
     * Menyimpan perubahan buku.
     */
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'cover_buku' => 'image|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori' => 'required|in:' . implode(',', Buku::getKategoriList()),
            'file_buku' => 'mimes:pdf|max:5120',
        ]);

        // Update cover jika ada file baru
        if ($request->hasFile('cover_buku')) {
            Storage::disk('public')->delete($buku->cover_buku);
            $buku->cover_buku = $request->file('cover_buku')->store('covers', 'public');
        }

        // Update file buku jika ada file baru
        if ($request->hasFile('file_buku')) {
            Storage::disk('public')->delete($buku->file_buku);
            $buku->file_buku = $request->file('file_buku')->store('books', 'public');
        }

        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Menghapus buku dari database.
     */
    public function destroy(Buku $buku)
    {
        Storage::disk('public')->delete([$buku->cover_buku, $buku->file_buku]);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}
