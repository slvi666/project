<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'subject_id',
        'nisn',
        'poto',
    ];

    /**
     * Relasi ke tabel users.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel subjects.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function mataPelajaran()
    {
        return MataPelajaran::whereJsonContains('siswa_ids', $this->id)->get();
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
    public function tugas()
    {
        return $this->hasMany(TugasSiswa::class, 'siswa_id');
    }
public function exams()
{
    return $this->belongsToMany(Exam::class, 'student_exams', 'siswa_id', 'exam_id')
                ->withPivot(['started_at', 'finished_at', 'score'])
                ->withTimestamps();
}
public function essayExamResults()
{
    return $this->hasMany(EssayExamResult::class);
}
public function answers()
{
    return $this->hasMany(Answer::class);
}
public function studentExams()
{
    return $this->hasMany(StudentExam::class, 'siswa_id');
}


}
