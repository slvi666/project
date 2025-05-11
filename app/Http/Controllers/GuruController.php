<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class GuruController extends Controller
{
    // Menampilkan daftar guru
    public function index()
    {
        if (auth()->user()->role_name === 'guru') {
            // Tampilkan hanya data guru yang sesuai dengan user yang login
            $guru = Guru::with('user')->where('user_id', auth()->user()->id)->get();
        } else {
            // Tampilkan semua data untuk admin
            $guru = Guru::with('user')->get();
        }

        return view('guru.index', compact('guru'));
    }


    // Menampilkan form untuk membuat guru baru
    public function create()
    {
        if (auth()->user()->role_name === 'guru') {
            // Hanya ambil user yang sedang login
            $users = User::where('id', auth()->user()->id)->get();
        } else {
            // Ambil semua user yang role_name-nya 'guru'
            $users = User::where('role_name', 'guru')->get();
        }


        return view('guru.create', compact('users'));
    }

    // Menyimpan data guru baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|unique:guru',
            'nama_guru' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'telepon' => 'required',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_guru', 'public');
        }

        Guru::create([
            'user_id' => $request->user_id,
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'telepon' => $request->telepon,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    // Menampilkan detail guru
    public function show($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('guru.show', compact('guru'));
    }

    // Menampilkan form untuk mengedit data guru
    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        $users = User::where('role_name', 'guru')->get(); // Mendapatkan user dengan role guru
        return view('guru.edit', compact('guru', 'users'));
    }

    // Mengupdate data guru
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|unique:guru,nip,' . $id,
            'nama_guru' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'telepon' => 'required',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update foto jika ada
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_guru', 'public');
            $guru->foto = $fotoPath;
        }

        $guru->update([
            'user_id' => $request->user_id,
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'telepon' => $request->telepon,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_bergabung' => $request->tanggal_bergabung,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate.');
    }

    // Menghapus data guru
    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
    public function cetakPerId($id)
{
    // Ambil data guru berdasarkan ID yang dipilih
    $guru = Guru::with('user')->findOrFail($id);

    // Menggenerate PDF
    $pdf = Pdf::loadView('guru.pdf', compact('guru'));

    // Menyajikan PDF ke browser atau bisa diunduh
    return $pdf->download('guru_' . $guru->nip . '.pdf');
}

}
