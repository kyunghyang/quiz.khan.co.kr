<?php

namespace Database\Factories;

use App\Enums\PointType;
use App\Models\PointHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PointHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PointHistory::class;

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
            "type" => PointType::READ_HISTORY_CREATED,
            "point" => PointType::$points[PointType::READ_HISTORY_CREATED],
            "created_at" => Carbon::now()
        ];
    }
}
