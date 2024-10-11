<?php

namespace Tests\Feature;

use App\Models\Checklist;
use App\Models\TripPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ChecklistTest extends TestCase
{
    use RefreshDatabase;

    protected $tripPlan;
    protected $checklist;

    protected function setUp(): void
    {
        parent::setUp();

        // ユーザーを作成してログインする
        $user = User::factory()->create();
        Auth::login($user);

        // TripPlanとChecklistを作成
        $this->tripPlan = TripPlan::factory()->create();
        $this->checklist = Checklist::factory()->create(['trip_plan_id' => $this->tripPlan->id]);
    }

    public function test_index_displays_checklists()
    {
        $tripPlan = TripPlan::factory()->create();
        $checklist = Checklist::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->get(route('checklists.index', $tripPlan->id));

        $response->assertStatus(200);
        $response->assertViewIs('checklists.index');
        $response->assertViewHas('checklists');
    }

    public function test_create_displays_create_form()
    {
        $tripPlan = TripPlan::factory()->create();

        $response = $this->get(route('checklists.create', $tripPlan->id));

        $response->assertStatus(200);
        $response->assertViewIs('checklists.create');
    }

    public function test_store_creates_checklist()
    {
        $tripPlan = TripPlan::factory()->create();

        $response = $this->post(route('checklists.store', $tripPlan->id), [
            'title' => 'New Checklist',
        ]);

        // データベースにチェックリストが作成されたことを確認
        $checklist = Checklist::where('title', 'New Checklist')->first(); // 作成されたチェックリストを取得

        $this->assertDatabaseHas('checklists', [
            'title' => 'New Checklist',
            'trip_plan_id' => $tripPlan->id,
        ]);

        $response->assertRedirect(route('tasks.create', [
            'trip_plan' => $tripPlan->id,
            'checklist' => $checklist->id, // このIDは実際のIDで置き換えてください
        ]));
    }

    public function test_edit_displays_edit_form()
    {
        $tripPlan = TripPlan::factory()->create();
        $checklist = Checklist::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->get(route('checklists.edit', [$tripPlan->id, $checklist->id]));

        $response->assertStatus(200);
        $response->assertViewIs('checklists.edit');
    }

    public function test_update_updates_checklist()
    {
        $tripPlan = TripPlan::factory()->create();
        $checklist = Checklist::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->put(route('checklists.update', [$tripPlan->id, $checklist->id]), [
            'title' => 'Updated Checklist',
        ]);

        $checklist->refresh();
        $this->assertEquals('Updated Checklist', $checklist->title);

        $response->assertRedirect(route('checklists.index', $tripPlan->id));
        $response->assertSessionHas('success', 'Updated Checklist.');
    }

    public function test_destroy_deletes_checklist()
    {
        $tripPlan = TripPlan::factory()->create();
        $checklist = Checklist::factory()->create(['trip_plan_id' => $tripPlan->id]);

        $response = $this->delete(route('checklists.destroy', [$tripPlan->id, $checklist->id]));

        $this->assertDatabaseMissing('checklists', [
            'id' => $checklist->id,
        ]);

        $response->assertRedirect(route('checklists.index', $tripPlan->id));
    }
}