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
    public function definition(): array
    {
        return [
        ];
    }
}