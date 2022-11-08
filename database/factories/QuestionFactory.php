<?php

namespace Database\Factories;

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->title,
            "description" => $this->faker->paragraph,
            "explain" => $this->faker->paragraph,
            "opened_at" => Carbon::now(),
            "url" => $this->faker->url,
        ];
    }
}
