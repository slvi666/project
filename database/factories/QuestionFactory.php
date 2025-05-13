<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'exam_id' => Exam::inRandomOrder()->first()->id, // Ambil id exam acak
            'question_text' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['pilihan_ganda', 'esai']),
            'choices' => $this->faker->randomElement([null, json_encode(['A' => 'Choice 1', 'B' => 'Choice 2', 'C' => 'Choice 3'])]),
            'correct_answer' => $this->faker->randomElement([null, 'A']),
        ];
    }
}
