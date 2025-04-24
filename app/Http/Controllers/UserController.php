<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan halaman dashboard pengguna.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user.Home_user'); // Sesuaikan dengan nama file tampilan Anda
    }
}
