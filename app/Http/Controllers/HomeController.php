<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard based on the user's role.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
    
        switch ($user->role_name) {
            case 'siswa':
                return view('siswa.Home_siswa');
            case 'guru':
                return view('guru.guru');
            case 'Admin':
                return view('Admin.home');
            case 'Orang Tua':
                return view('orang_tua.orang_tua');
            case 'calon_siswa':
                if ($user->role_name === 'Admin') {
                    $pendaftarans = \App\Models\FormulirPendaftaran::with('user')->latest()->get();
                } else {
                    $pendaftarans = \App\Models\FormulirPendaftaran::with('user')
                        ->where('user_id', $user->id)
                        ->latest()
                        ->get();
                }
                return view('calon_siswa.home', compact('pendaftarans'));
            default:
                return redirect('/')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
}    
