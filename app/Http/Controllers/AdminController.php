<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Admin.home'); // Sesuaikan dengan nama file tampilan Anda
    }
}
