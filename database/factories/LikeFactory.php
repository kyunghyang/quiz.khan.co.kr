<?php

namespace Database\Factories;

use App\Models\Like;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Like::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::first() ?? Product::factory()->create();
        $user = User::first() ?? User::factory()->create();

        return [
            "user_id" => $user->id,
            "product_id" => $product->id
        ];
    }
}
