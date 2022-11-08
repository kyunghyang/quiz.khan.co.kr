<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Option;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Answer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::first() ?? User::factory()->create();
        $question = Question::first() ?? Question::factory()->create();
        $option = Option::first() ?? Option::factory()->create();

        return [
            "user_id" => $user->id,
            "question_id" => $question->id,
            "option_id" => $option->id
        ];
    }
}
