<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasSiswa extends Model
{
    use HasFactory;

    protected $table = 'tugas_siswa';

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'subject_id',
        'judul_tugas',
        'deskripsi',
        'tanggal_diberikan',
        'deadline',
        'file_soal',
        'file_jawaban',
        'status',
        'nilai_tugas', // Tambahkan ini
    ];

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Relasi ke guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    // Relasi ke subject
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
