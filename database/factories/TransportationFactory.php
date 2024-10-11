<?php

namespace Database\Factories;

use App\Models\Transportation;
use App\Models\TripPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transportation>
 */
class TransportationFactory extends Factory
{
    protected $model = Transportation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trip_plan_id' => TripPlan::factory(), // TripPlan のファクトリを使って関連付け
            'date' => $this->faker->date(),
            'departure_time' => $this->faker->time(),
            'arrival_time' => $this->faker->time(),
            'departure_location' => $this->faker->city,
            'arrival_location' => $this->faker->city,
            'transportation_mode' => $this->faker->word,
            'notes' => $this->faker->sentence,
        ];
    }
}