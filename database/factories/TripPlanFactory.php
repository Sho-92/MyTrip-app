<?php

namespace Database\Factories;

use App\Models\TripPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TripPlan>
 */
class TripPlanFactory extends Factory
{
    protected $model = TripPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,  // Fakerを使用
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'country' => $this->faker->country,
            'city' => $this->faker->city,
        ];
    }
}