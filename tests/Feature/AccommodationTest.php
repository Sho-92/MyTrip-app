<?php

namespace Tests\Feature;

use App\Models\Accommodation;
use App\Models\TripPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccommodationTest extends TestCase
{
    use RefreshDatabase;

    protected $tripPlan;

    protected function setUp(): void
    {
        parent::setUp();

        // ユーザーを作成してログインする
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->tripPlan = TripPlan::factory()->create();
    }

    public function test_it_can_create_accommodation()
    {

        $response = $this->post(route('accommodations.store', $this->tripPlan->id), [
            'check_in_date' => '2024-10-01',
            'check_out_date' => '2024-10-05',
            'check_in_time' => '14:00',
            'check_out_time' => '11:00',
            'hotel_name' => 'Test Hotel',
            'address' => '123 Test St, Test City',
            'notes' => 'Some notes',
        ]);

        $response->assertRedirect(route('trip_plans.show', $this->tripPlan->id));
        $this->assertDatabaseHas('accommodations', [
            'hotel_name' => 'Test Hotel',
            'trip_plan_id' => $this->tripPlan->id,
        ]);
    }
}