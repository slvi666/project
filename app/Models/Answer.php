<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan (opsional, jika tabel tidak sesuai konvensi)
    protected $table = 'answers';

    // Menentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'student_exam_id',
        'question_id',
        'answer_text',
        'score',
    ];

    // Relasi dengan model StudentExam
    public function studentExam()
    {
        return $this->belongsTo(StudentExam::class);
    }

    // Relasi dengan model Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
