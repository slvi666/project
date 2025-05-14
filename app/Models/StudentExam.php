<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExam extends Model
{
    use HasFactory;

    protected $table = 'student_exams';

    protected $fillable = [
        'siswa_id',
        'exam_id',
        'started_at',
        'finished_at',
        'score',
    ];

    /**
     * Relasi ke model Siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Relasi ke model Exam.
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
    public function answers()
{
    return $this->hasMany(Answer::class);
}

}
