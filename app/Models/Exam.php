<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan konvensi default (misalnya: "exams")
    protected $table = 'exams';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'subject_id',
        'exam_title',
        'description',
        'question_type',
        'duration',
        'start_time',
        'end_time',
    ];

    // Relasi: Sebuah Exam berhubungan dengan satu Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Relasi: Sebuah Exam memiliki banyak Question
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
