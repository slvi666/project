<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements ToModel, WithHeadingRow
{
    protected $exam;

    public function __construct($exam)
    {
        $this->exam = $exam;
    }

    public function model(array $row)
    {
        return new Question([
            'exam_id' => $this->exam->id,
            'question_text' => $row['question_text'] ?? '',

            // Ambil type dari exam
            'type' => $this->exam->question_type,

            // Ubah 'choices' dari "A|B|C|D" menjadi ["A","B","C","D"] dalam format JSON
            'choices' => isset($row['choices']) && !empty($row['choices'])
                ? json_encode(explode('|', $row['choices']))
                : null,

            // Bisa kosong untuk soal esai
            'correct_answer' => $row['correct_answer'] ?? null,
        ]);
    }
}
