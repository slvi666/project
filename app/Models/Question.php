<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan penamaan default
    protected $table = 'questions';

    // Tentukan kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'exam_id',
        'question_text',
        'type',
        'choices',
        'correct_answer',
    ];

    // Tentukan tipe data untuk kolom json
    protected $casts = [
        'choices' => 'array', // Agar kolom 'choices' bisa otomatis menjadi array saat diakses
    ];

    // Relasi dengan model Exam (karena ada foreign key 'exam_id')
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
public function answers()
{
    return $this->hasMany(Answer::class);
}


}
