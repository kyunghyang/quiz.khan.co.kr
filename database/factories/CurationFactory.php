<?php

namespace Database\Factories;

use App\Models\Curation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Curation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::first() ?? User::factory()->create();

        return [
            "user_id" => $user->id,
            "title" => $this->faker->title
        ];
    }
}
