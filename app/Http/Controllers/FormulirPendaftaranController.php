<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormulirPendaftaran;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FormulirPendaftaranController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = auth()->user(); 
    
        // Jika yang login adalah Admin, tampilkan semua data
        if ($user->role_name === 'Admin') {
            $formulirs = FormulirPendaftaran::with('user')->get();
        } else {
            // Jika bukan admin, tampilkan hanya data milik pengguna yang sedang login
            $formulirs = FormulirPendaftaran::with('user')->where('user_id', $user->id)->get();
        }
    
        return view('formulir.index', compact('formulirs'));
    }
    

    public function create()
    {
        $users = User::where('role_name', 'calon_siswa')->get();
        return view('formulir.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:formulir_pendaftaran,nik',
            'user_id' => 'required|exists:users,id',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'nama_orangtua' => 'required|string',
            'pekerjaan_orangtua' => 'required|string',
            'penghasilan_orangtua' => 'required|numeric',
            'jarak_rumah_sekolah' => 'required|numeric',
            'kendaraan' => 'required|string',
            'nama_bapak' => 'required|string',
            'asal_sekolah' => 'required|string',
            'tahun_lulus' => 'required|integer',
            'status' => 'in:Pending,Tidak Lulus,Lulus',
            'nilai_us' => 'nullable|numeric|min:0|max:100',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'berkas_sertifikat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $fotoPath = $request->file('foto')->store('foto_pendaftar', 'public');
        $sertifikatPath = $request->hasFile('berkas_sertifikat') 
            ? $request->file('berkas_sertifikat')->store('sertifikat_pendaftar', 'public') 
            : null;

        FormulirPendaftaran::create(array_merge(
            $request->all(),
            ['foto' => $fotoPath, 'berkas_sertifikat' => $sertifikatPath]
        ));

        return redirect()->route('formulir.index')->with('success', 'Pendaftaran berhasil disimpan!');
    }

    public function show($id)
    {
        $formulir = FormulirPendaftaran::with('user')->findOrFail($id);
        return view('formulir.show', compact('formulir'));
    }

    public function edit($id)
    {
        $formulir = FormulirPendaftaran::findOrFail($id);
        $users = User::where('role_name', 'calon_siswa')->get();
        return view('formulir.edit', compact('formulir', 'users'));
    }

    public function update(Request $request, $id)
    {
        $formulir = FormulirPendaftaran::findOrFail($id);

        $request->validate([
            'nik' => 'required|unique:formulir_pendaftaran,nik,' . $id,
            'user_id' => 'required|exists:users,id',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'nama_orangtua' => 'required|string',
            'pekerjaan_orangtua' => 'required|string',
            'penghasilan_orangtua' => 'required|numeric',
            'jarak_rumah_sekolah' => 'required|numeric',
            'kendaraan' => 'required|string',
            'nama_bapak' => 'required|string',
            'asal_sekolah' => 'required|string',
            'tahun_lulus' => 'required|integer',
            'status' => 'in:Pending,Tidak Lulus,Lulus',
            'nilai_us' => 'nullable|numeric|min:0|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'berkas_sertifikat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle foto
        if ($request->hasFile('foto')) {
            if ($formulir->foto && Storage::disk('public')->exists($formulir->foto)) {
                Storage::disk('public')->delete($formulir->foto);
            }
            $fotoPath = $request->file('foto')->store('foto_pendaftar', 'public');
        } else {
            $fotoPath = $formulir->foto;
        }

        // Handle berkas sertifikat
        if ($request->hasFile('berkas_sertifikat')) {
            if ($formulir->berkas_sertifikat && Storage::disk('public')->exists($formulir->berkas_sertifikat)) {
                Storage::disk('public')->delete($formulir->berkas_sertifikat);
            }
            $sertifikatPath = $request->file('berkas_sertifikat')->store('sertifikat_pendaftar', 'public');
        } else {
            $sertifikatPath = $formulir->berkas_sertifikat;
        }

        $formulir->update(array_merge(
            $request->all(),
            ['foto' => $fotoPath, 'berkas_sertifikat' => $sertifikatPath]
        ));

        return redirect()->route('formulir.index')->with('success', 'Pendaftaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $formulir = FormulirPendaftaran::findOrFail($id);

        Storage::disk('public')->delete($formulir->foto);
        if ($formulir->berkas_sertifikat) {
            Storage::disk('public')->delete($formulir->berkas_sertifikat);
        }

        $formulir->delete();
        return redirect()->route('formulir.index')->with('success', 'Pendaftaran berhasil dihapus!');
    }
}
