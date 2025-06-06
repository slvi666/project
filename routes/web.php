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
use App\Http\Controllers\DokKegiatanController;
use App\Http\Controllers\EssayExamResultController;



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
    Route::get('formulir/{id}/cetak', [FormulirPendaftaranController::class, 'cetak'])->name('formulir.cetak');
    Route::resource('formulir', FormulirPendaftaranController::class);
});
use App\Http\Controllers\BookssiswaController;

Route::get('/buku-siswa', [BookssiswaController::class, 'index'])->name('bookssiswa.index');
Route::resource('dok_kegiatan', DokKegiatanController::class);


Route::get('/siswa/{id}/print', [SiswaController::class, 'print'])->name('siswa.print');
Route::get('guru/{id}/cetak', [GuruController::class, 'cetakPerId'])->name('guru.cetak');
Route::post('/registrasi/import', [RegistrasiController::class, 'import'])->name('registrasi.import');


use App\Http\Controllers\MessageController;

Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');  // Tidak ada receiver_id di sini
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{receiver_id}', [MessageController::class, 'show'])->name('messages.show');
    Route::get('/messages/edit/{id}', [MessageController::class, 'edit'])->name('messages.edit');
    Route::put('/messages/{id}', [MessageController::class, 'update'])->name('messages.update');
    Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
});
Route::get('/messages/get-users', [MessageController::class, 'getUsers'])->name('messages.getUsers');
Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');



use App\Http\Controllers\ExamController;

Route::middleware(['auth', 'isAdmin'])->group(function () {
 Route::get('exams/create', [ExamController::class, 'create'])->name('exams.create');   
 Route::get('exams/{exam}/edit', [ExamController::class, 'edit'])->name('exams.edit');
});

Route::middleware(['auth'])->group(function () {
 Route::get('exams', [ExamController::class, 'index'])->name('exams.index');
Route::post('exams', [ExamController::class, 'store'])->name('exams.store');
Route::get('exams/{exam}', [ExamController::class, 'show'])->name('exams.show');
Route::put('exams/{exam}', [ExamController::class, 'update'])->name('exams.update');
Route::delete('exams/{exam}', [ExamController::class, 'destroy'])->name('exams.destroy');
   
    
});
use App\Http\Controllers\QuestionController;

Route::prefix('exams/{examId}')->group(function () {
    Route::get('questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('questions/{questionId}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('questions/{questionId}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('questions/{questionId}', [QuestionController::class, 'destroy'])->name('questions.destroy');
});
// use App\Http\Controllers\StudentExamController;

// Route::resource('student_exams', StudentExamController::class);


use App\Http\Controllers\AnswerController;

Route::resource('answers', AnswerController::class);
Route::get('answers/{id}/auto-grade', [AnswerController::class, 'autoGrade'])->name('answers.autoGrade');
Route::post('/student-exams/{id}/calculate-score', [StudentExamController::class, 'calculateScore'])->name('student_exams.calculateScore');

Route::resource('essay_exam_results', EssayExamResultController::class);
Route::post('/exams/{examId}/questions/import', [QuestionController::class, 'import'])->name('questions.import');
Route::post('/questions/import/{examId}', [QuestionController::class, 'importExcel'])->name('questions.importExcel');

use App\Http\Controllers\StudentExamController;

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/exam/{exam}/start', [StudentExamController::class, 'start'])->name('exam.start');
    Route::post('/exam/{exam}/submit', [StudentExamController::class, 'submit'])->name('exam.submit');
    Route::get('/exam-list', [StudentExamController::class, 'list'])->name('exam.list');
});

Route::middleware(['auth'])->group(function () {
Route::get('/student-exams', [StudentExamController::class, 'index'])->name('student-exams.index');
Route::get('/siswa/exam', [StudentExamController::class, 'index'])->name('siswa.exam.index');
Route::get('/siswa/exam/{id}/edit', [StudentExamController::class, 'edit'])->name('siswa.exam.edit');
Route::put('/siswa/exam/{id}', [StudentExamController::class, 'update'])->name('siswa.exam.update');
Route::get('/student-exams/{id}', [StudentExamController::class, 'show'])->name('siswa.exam.show');
  
});