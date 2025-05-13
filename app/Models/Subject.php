<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_name',
        'subject_name',
    ];
    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
    public function mataPelajaran()
    {
        return $this->hasMany(MataPelajaran::class, 'subject_id');
    }
    public function materiPembelajaran()
    {
        return $this->hasMany(MateriPembelajaran::class, 'subject_id');
    }
    public function tugas()
    {
        return $this->hasMany(TugasSiswa::class, 'subject_id');
    }
     // Relasi: Sebuah Subject memiliki banyak Exam
   // Relasi dengan Exam
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
