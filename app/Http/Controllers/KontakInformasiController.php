<?php

namespace App\Http\Controllers;

use App\Models\KontakInformasi;
use Illuminate\Http\Request;

class KontakInformasiController extends Controller
{
    public function index()
    {
        $kontaks = KontakInformasi::all();
        return view('KontakInformasi.index', compact('kontaks'));
    }

    public function create()
    {
        return view('KontakInformasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_identitas' => 'required|string|max:255',
            'email' => 'nullable|email',
            'no_telpon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'no_wa' => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:100',
            'fb' => 'nullable|string|max:100',
        ]);

        KontakInformasi::create($request->all());

        return redirect()->route('kontak-informasi.index')
            ->with('success', 'Data kontak berhasil disimpan.');
    }

    public function edit(KontakInformasi $kontakInformasi)
    {
        return view('KontakInformasi.edit', compact('kontakInformasi'));
    }

    public function update(Request $request, KontakInformasi $kontakInformasi)
    {
        $request->validate([
            'nama_identitas' => 'required|string|max:255',
            'email' => 'nullable|email',
            'no_telpon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'no_wa' => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:100',
            'fb' => 'nullable|string|max:100',
        ]);

        $kontakInformasi->update($request->all());

        return redirect()->route('kontak-informasi.index')
            ->with('success', 'Data kontak berhasil diperbarui.');
    }

    public function destroy(KontakInformasi $kontakInformasi)
    {
        $kontakInformasi->delete();

        return redirect()->route('kontak-informasi.index')
            ->with('success', 'Data kontak berhasil dihapus.');
    }

    public function show($id)
    {
        $kontak = KontakInformasi::findOrFail($id);
        return view('KontakInformasi.show', compact('kontak'));
    }
}
