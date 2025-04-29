<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\TugasSiswaController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\SeleksiBerkasController;
use App\Http\Controllers\FormulirPendaftaranController;
use App\Http\Controllers\KontakInformasiController;
use App\Http\Controllers\MateriPembelajaranController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rute untuk halaman depan
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk halaman home yang akan memanggil HomeController
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('registrasi', RegistrasiController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('buku', BukuController::class);
});

Route::middleware(['auth'])->group(function () {});
// bagian kalender akademik
Route::controller(FullCalenderController::class)->group(function () {
    Route::get('fullcalender', 'index');
    Route::post('fullcalenderAjax', 'ajax');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('subjects', SubjectController::class);
});
Route::put('seleksi-berkas/{seleksiBerkas}', [SeleksiBerkasController::class, 'update'])->name('seleksi-berkas.update');

// bagian subject

Route::middleware(['auth'])->group(function () {
    Route::resource('guru', GuruController::class);
});
//Bagian guru
Route::middleware(['auth'])->group(function () {
    Route::resource('seleksi-berkas', SeleksiBerkasController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('profil_siswa', SiswaController::class);
    Route::get('/siswa', [SiswaController::class, 'index'])->name('profil_siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('profil_siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('profil_siswa.store');
    Route::get('/siswa/{siswa}', [SiswaController::class, 'show'])->name('profil_siswa.show');
    Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('profil_siswa.edit');
    Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('profil_siswa.update');
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('profil_siswa.destroy');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('mata-pelajaran', MataPelajaranController::class);
});
// web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/absensi/{id}/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::get('/absensi/{id}', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/{id}', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/{id}/cetak', [AbsensiController::class, 'cetak'])->name('absensi.cetak');
    Route::get('/laporan-absensi', [AbsensiController::class, 'laporan'])->name('absensi.laporan');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('materi', MateriPembelajaranController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('tugas', TugasSiswaController::class);

    Route::get('tugas/{id}/download-soal', [TugasSiswaController::class, 'downloadSoal'])->name('tugas.download.soal');
    Route::get('tugas/{id}/download-jawaban', [TugasSiswaController::class, 'downloadJawaban'])->name('tugas.download.jawaban');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('pengumuman', PengumumanController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('kontak-informasi', KontakInformasiController::class);
});
Route::resource('faq', FaqController::class);
Route::middleware(['auth'])->group(function () {
    Route::resource('formulir', FormulirPendaftaranController::class);
});
