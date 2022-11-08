<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            "mood_id" => null,
            "sub_category_id" => null,
            "title" => $this->faker->unique()->name,
            "price" => rand(100, 10000),
            "count_order" => rand(0, 10000),
            "value_discount" => 0,
            "agency_store" => rand(0,1),
            "department_store" => rand(0,1),
            "direct_store" => rand(0,1)
        ];
    }
}
