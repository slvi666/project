<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BookssiswaController extends Controller
{
    /**
     * Menampilkan daftar buku untuk siswa.
     */
    public function index()
    {
        $buku = Buku::latest()->get();
        return view('bookssiswa.index', compact('buku'));
    }
}
