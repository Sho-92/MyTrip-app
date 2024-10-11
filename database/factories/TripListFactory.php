<?php

namespace Database\Factories;

use App\Models\TripList;
use App\Models\TripPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TripList>
 */
class TripListFactory extends Factory
{
    protected $model = TripList::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trip_plan_id' => TripPlan::factory(), // TripPlanに関連付け
            'date' => $this->faker->date(),
            'destination' => $this->faker->city(),
            'notes' => $this->faker->paragraph(),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
        ];
    }
}