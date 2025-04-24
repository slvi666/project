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

        // Get the total number of RencanaKegiatan

        // Periksa peran pengguna dan arahkan ke halaman yang sesuai
        switch ($user->role_name) {
            case 'siswa':
                return view('siswa.Home_siswa'); // Pass the data to the siswa view
            case 'guru':
                return view('guru.guru'); // Pass the data to the guru view
            case 'Admin':
                // Pass the total counts to the Admin view
                return view('Admin.home');
            case 'Orang Tua':
                return view('orang_tua.orang_tua'); // Pass the data to the orang_tua view
            case 'calon_siswa':
                    return view('calon_siswa.home'); // Pass the data to the orang_tua view
            default:
                return redirect('/')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
}
