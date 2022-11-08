<?php

namespace Database\Factories;

use App\Enums\Category;
use App\Models\Curation;
use App\Models\Newspaper;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewspaperFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Newspaper::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $curation = Curation::first() ?? Curation::factory()->create();

        return [
            "curation_id" => $curation->id,
            "title" => $this->faker->title,
            "description" => $this->faker->paragraph,
            "url" => $this->faker->url,
            "img_url" => $this->faker->url,
            "category" => Category::getValues()[rand(0, count(Category::getValues()) - 1)]
        ];
    }
}
