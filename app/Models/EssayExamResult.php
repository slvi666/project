<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EssayExamResult extends Model
{
    use HasFactory;

    protected $table = 'essay_exam_results';

    protected $fillable = [
        'exam_id',
        'siswa_id',
        'question_text',
        'answer_text',
        'score',
        'feedback',
    ];

    // Relasi ke Exam
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
