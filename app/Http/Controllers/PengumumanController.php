<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    // Tampilkan semua pengumuman
    public function index()
    {
        $pengumuman = Pengumuman::all();
        return view('pengumuman.index', compact('pengumuman'));
    }

    // Tampilkan form tambah pengumuman
    public function create()
    {
        return view('pengumuman.create');
    }

    // Simpan pengumuman baru
    public function store(Request $request)
    {
        $request->validate([
            'judul_pengumuman' => 'required|string|max:255',
            'isi_pengumuman' => 'required',
            'deskripsi_pengumuman' => 'nullable',
            'status' => 'required|in:aktif,non aktif',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        Pengumuman::create($request->all());

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pengumuman.edit', compact('pengumuman'));
    }

    // Update pengumuman
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_pengumuman' => 'required|string|max:255',
            'isi_pengumuman' => 'required',
            'deskripsi_pengumuman' => 'nullable',
            'status' => 'required|in:aktif,non aktif',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update($request->all());

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    // Hapus pengumuman
    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pengumuman.show', compact('pengumuman'));
    }
}
