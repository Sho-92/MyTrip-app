<?php

namespace Tests\Feature;

use App\Models\Transportation;
use App\Models\TripPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TransportationTest extends TestCase
{

    use RefreshDatabase;

    protected $tripPlan;

    public function setUp(): void
    {
        parent::setUp();

        // ユーザーを作成してログインする
        $user = User::factory()->create();
        Auth::login($user);
    }

    public function test_it_can_display_transportation_index()
    {
        $tripPlan = TripPlan::factory()->create();
        $transportation = Transportation::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->get(route('transportations.index', $tripPlan->id));

        $response->assertStatus(200);
        $response->assertViewIs('transportations.index');
        $response->assertViewHas('transportations', fn ($value) =>
            $value instanceof \Illuminate\Database\Eloquent\Collection && $value->contains($transportation)
        );
    }

    public function test_it_can_show_transportation_creation_form()
    {
        $tripPlan = TripPlan::factory()->create();

        $response = $this->get(route('transportations.create', $tripPlan->id));

        $response->assertStatus(200);
        $response->assertViewIs('transportations.create');
        $response->assertViewHas('tripPlan');
    }

    public function test_it_can_store_transportation()
    {
        $tripPlan = TripPlan::factory()->create();

        $response = $this->post(route('transportations.store', $tripPlan->id), [ // tripPlan->idを渡す
            'trip_plan_id' => $tripPlan->id,
            'date' => '2024-10-10',
            'departure_time' => '09:00',
            'arrival_time' => '10:00',
            'departure_location' => 'Tokyo',
            'arrival_location' => 'Osaka',
            'transportation_mode' => 'Train',
            'notes' => 'No notes',
        ]);

        $this->assertDatabaseHas('transportations', [
            'departure_location' => 'Tokyo',
            'arrival_location' => 'Osaka',
        ]);

        $response->assertRedirect(route('trip_plans.show', $tripPlan->id));
        $response->assertSessionHas('success', 'Transportation added successfully!');
    }

    public function test_it_can_show_transportation()
    {
        $tripPlan = TripPlan::factory()->create(); // tripPlanを作成
        $transportation = Transportation::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->get(route('transportations.show', [$tripPlan->id, $transportation->id])); // tripPlanのIDを渡す

        $response->assertStatus(200);
        $response->assertViewIs('transportations.show');
        $response->assertViewHas('transportation', $transportation);
    }

    public function test_it_can_show_transportation_edit_form()
    {
        $tripPlan = TripPlan::factory()->create();
        $transportation = Transportation::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->get(route('transportations.edit', [$tripPlan->id, $transportation->id])); // tripPlanのIDを渡す

        $response->assertStatus(200);
        $response->assertViewIs('transportations.edit');
        $response->assertViewHas('transportation', $transportation);
    }

    public function test_it_can_update_transportation()
    {
        $tripPlan = TripPlan::factory()->create();
        $transportation = Transportation::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->put(route('transportations.update', [$tripPlan->id, $transportation->id]), [ // tripPlanのIDを渡す
            'date' => '2024-10-11',
            'departure_time' => '10:00',
            'arrival_time' => '11:00',
            'departure_location' => 'New Tokyo', // 変更する値
            'arrival_location' => 'New Osaka', // 変更する値
            'transportation_mode' => 'Bus',
            'notes' => 'Updated notes',
        ]);

        $this->assertDatabaseHas('transportations', [
            'departure_location' => 'New Tokyo', // 変更後の値
            'arrival_location' => 'New Osaka', // 変更後の値
        ]);

        $response->assertRedirect(route('trip_plans.show', $tripPlan->id));
        $response->assertSessionHas('success', 'Transportation updated successfully.');
    }

    public function test_it_can_delete_transportation()
    {
        $tripPlan = TripPlan::factory()->create();
        $transportation = Transportation::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->delete(route('transportations.destroy', [$tripPlan->id, $transportation->id])); // tripPlanのIDを渡す

        $this->assertDatabaseMissing('transportations', [
            'id' => $transportation->id,
        ]);

        $response->assertRedirect(route('trip_plans.show', $tripPlan->id));
        $response->assertSessionHas('success', 'Transportation deleted successfully.');
    }
}