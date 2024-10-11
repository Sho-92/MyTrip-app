<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Checklist;
use App\Models\TripPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // 認証されたユーザーを作成
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_it_can_display_tasks_for_a_checklist()
    {
        $tripPlan = TripPlan::factory()->create();
        $checklist = Checklist::factory()->create(['trip_plan_id' => $tripPlan->id]);
        $tasks = Task::factory()->count(3)->create(['checklist_id' => $checklist->id]);

        $response = $this->get(route('checklists.index', ['trip_plan' => $tripPlan->id]));

        $response->assertStatus(200);
        $response->assertViewHas('tasks');
        foreach ($tasks as $task) {
            $response->assertSee($task->title);
        }
    }
}