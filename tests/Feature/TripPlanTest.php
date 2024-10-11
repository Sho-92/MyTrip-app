<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TripPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

class TripPlanTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $tripPlan;

    protected function setUp(): void
    {
        parent::setUp();

        // テスト用の固定日時
        \Carbon\Carbon::setTestNow(\Carbon\Carbon::parse('2024-10-11'));

        // 認証されたユーザーを作成
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        // TripPlanを作成
        $this->tripPlan = TripPlan::factory()->create();
    }

    public function test_it_can_display_the_trip_plan_creation_form()
    {
        $response = $this->get(route('trip_plans.create'));

        $response->assertStatus(200);
        $response->assertViewIs('trip_plans.create');
    }

    public function test_it_can_store_a_trip_plan()
    {
        $tripPlanData = [
            'title' => 'My Trip',
            'start_date' => '2024-10-11',
            'end_date' => '2024-10-16',
            'country' => 'Japan',
            'city' => 'Tokyo',
        ];

        $response = $this->post(route('trip_plans.store'), $tripPlanData);

    
        $this->assertDatabaseHas('trip_plans', $tripPlanData);
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('success', 'Your request was successful');
        $response->assertSessionHasNoErrors(); // エラーがないことも確認
    }

    public function test_it_can_display_a_trip_plan()
    {
        $response = $this->get(route('trip_plans.show', $this->tripPlan->id));

        $response->assertStatus(200);
        $response->assertViewIs('trip_plans.show');
        $response->assertViewHas('tripPlan', $this->tripPlan);
    }

    public function test_it_can_display_the_trip_plan_edit_form()
    {
        $response = $this->get(route('trip_plans.edit', $this->tripPlan->id));

        $response->assertStatus(200);
        $response->assertViewIs('trip_plans.edit');
        $response->assertViewHas('tripPlan', $this->tripPlan);
    }

    public function test_it_can_update_a_trip_plan()
    {
        $updatedData = [
            'title' => 'Updated Trip Title',
            'start_date' => '2024-10-11',
            'end_date' => '2024-10-16',
            'country' => 'Japan',
            'city' => 'Kyoto',
        ];

        $response = $this->put(route('trip_plans.update', $this->tripPlan->id), $updatedData);

        $this->assertDatabaseHas('trip_plans', $updatedData);
        $response->assertRedirect(route('trip_plans.show', $this->tripPlan->id));
        $response->assertSessionHas('success', 'Your travel plan has been updated.');
        $response->assertSessionHasNoErrors(); // エラーがないことも確認
    }

    public function test_it_can_delete_a_trip_plan()
    {
        $tripPlanToDelete = TripPlan::factory()->create();
        $response = $this->delete(route('trip_plans.destroy', $tripPlanToDelete->id));

        $this->assertDatabaseMissing('trip_plans', ['id' => $tripPlanToDelete->id]);
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('success', 'Your travel plan has been deleted.');
        $response->assertSessionHasNoErrors();
    }
}