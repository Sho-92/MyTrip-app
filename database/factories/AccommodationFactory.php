<?php

namespace Database\Factories;

use App\Models\Accommodation;
use App\Models\TripPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accommodation>
 */
class AccommodationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trip_plan_id' => TripPlan::factory(), // TripPlanのファクトリーを使用して関連する旅行計画を生成
            'check_in_date' => $this->faker->date(),
            'check_out_date' => $this->faker->date(),
            'check_in_time' => $this->faker->time('H:i'),
            'check_out_time' => $this->faker->time('H:i'),
            'hotel_name' => $this->faker->company,
            'address' => $this->faker->address,
            'notes' => $this->faker->sentence,
        ];
    }
}