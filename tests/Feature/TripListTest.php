<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TripPlan;
use App\Models\TripList;
use App\Models\Checklist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TripListTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $tripPlan;
    protected $tripList; // TripListのためのプロパティ


    protected function setUp(): void
    {
        parent::setUp();

        // テスト用のユーザーを作成してログイン
        $user = User::factory()->create();
        Auth::login($user);

    }

    public function test_it_can_display_trip_lists_index()
    {
        $tripPlan = TripPlan::factory()->create();
        $tripList = TripList::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->get(route('trip_lists.index', $tripPlan->id));

        $response->assertStatus(200);
        $response->assertViewIs('trip_lists.index');
        $response->assertViewHas('tripLists', function ($tripLists) use ($tripList){
            return $tripLists instanceof \Illuminate\Database\Eloquent\Collection && $tripLists->contains($tripList);
        });
    }

    public function test_it_can_show_trip_list_creation_form()
    {
        $tripPlan = TripPlan::factory()->create();

        $response = $this->get(route('trip_lists.create', $tripPlan->id));

        $response->assertStatus(200);
        $response->assertViewIs('trip_lists.create');
        $response->assertViewHas('tripPlan', $tripPlan);
    }

    public function test_it_can_store_trip_list()
    {
        $tripPlan = TripPlan::factory()->create();

        $data = [
            'date' => '2024-10-10',
            'destination' => 'Tokyo',
            'notes' => 'Meeting with clients',
            'start_time' => '10:00',
            'end_time' => '12:00',
        ];

        $response = $this->post(route('trip_lists.store', $tripPlan->id), $data);

        $response->assertRedirect(route('trip_plans.show', $tripPlan->id));
        $this->assertDatabaseHas('trip_lists', $data + ['trip_plan_id' => $tripPlan->id]);
    }

    public function test_it_can_display_trip_list()
    {
        $tripPlan = TripPlan::factory()->create();
        $tripList = TripList::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->get(route('trip_lists.show', [$tripPlan->id, $tripList->id]));

        $response->assertStatus(200);
        $response->assertViewIs('trip_lists.show');
        $response->assertViewHas('tripList', $tripList);
    }

    public function test_it_can_show_trip_list_edit_form()
    {
        $tripPlan = TripPlan::factory()->create();
        $tripList = TripList::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->get(route('trip_lists.edit', [$tripPlan->id, $tripList->id]));

        $response->assertStatus(200);
        $response->assertViewIs('trip_lists.edit');
        $response->assertViewHas('tripPlan', $tripPlan);
        $response->assertViewHas('tripList', $tripList);
    }

    public function test_it_can_update_trip_list()
    {
        $tripPlan = TripPlan::factory()->create();
        $tripList = TripList::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $data = [
            'date' => '2024-10-11',
            'destination' => 'Osaka',
            'notes' => 'Conference',
            'start_time' => '13:00',
            'end_time' => '15:00',
        ];

        $response = $this->put(route('trip_lists.update', [$tripPlan->id, $tripList->id]), $data);

        $response->assertRedirect(route('trip_plans.show', $tripPlan->id));
        $this->assertDatabaseHas('trip_lists', $data + ['id' => $tripList->id]);
    }

    public function test_it_can_delete_trip_list()
    {
        $tripPlan = TripPlan::factory()->create();
        $tripList = TripList::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->delete(route('trip_lists.destroy', [$tripPlan->id, $tripList->id]));

        $response->assertRedirect(route('trip_plans.show', $tripPlan->id));
        $this->assertDatabaseMissing('checklists', [
            'id' => $tripList->id,
        ]);
    }
}