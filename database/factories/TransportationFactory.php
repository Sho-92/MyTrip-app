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
    public function definition(): array
    {
        return [
        ];
    }
}