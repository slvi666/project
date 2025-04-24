<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormulirPendaftaran;
use App\Models\SeleksiBerkas;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role_name === 'Admin') {
            $laporan = FormulirPendaftaran::with('user', 'seleksiBerkas')->get();
        } else {
            $laporan = FormulirPendaftaran::with('user', 'seleksiBerkas')
                        ->where('user_id', $user->id)
                        ->get();
        }
        
        return view('formulir.laporan', compact('laporan'));
    }
}
