<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // pastikan import User

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exams';

    protected $fillable = [
        'subject_id',
        'guru_id', // jangan lupa tambahkan supaya bisa mass assignable kalau perlu
        'exam_title',
        'description',
        'question_type',
        'duration',
        'start_time',
        'end_time',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'student_exams', 'exam_id', 'siswa_id')
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
}
