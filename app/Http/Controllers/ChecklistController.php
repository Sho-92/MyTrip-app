<?php

namespace App\Http\Controllers;
use App\Models\TripPlan;
use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function index(TripPlan $trip_plan)
    {
        $checklists = $trip_plan->checklists;
        $tasks = Task::whereIn('checklist_id', $checklists->pluck('id'))->get(); // すべてのチェックリストのタスクを取得

        return view('checklists.index', [
            'trip_plan' => $trip_plan,
            'checklists' => $checklists,
            'tasks' => $tasks, // タスクをビューに渡す
            'checklist' => $checklists->first(),
        ]);
    }

    public function create(TripPlan $trip_plan)
    {
        return view('checklists.create', compact('trip_plan'));
    }

    public function store(Request $request, $trip_plan_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Create new checklist
        $checklist = new Checklist();
        $checklist->title = $request->title;
        $checklist->trip_plan_id = $trip_plan_id;
        $checklist->save();

        // Redirect to create task
        return redirect()->route('tasks.create', [
            'trip_plan' => $trip_plan_id,
            'checklist' => $checklist->id
        ]);
    }

    public function edit($trip_plan_id, Checklist $checklist)
    {
        return view('checklists.edit', compact('trip_plan_id', 'checklist'));
    }

    public function update(Request $request, $trip_plan_id, Checklist $checklist)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $checklist->update(['title' => $request->title]);

        // Check if task exists in request
        if ($request->has('tasks')) {
            // Update existing tasks or add new tasks
            foreach ($request->tasks as $task_id => $taskData) {
                if (is_numeric($task_id)) {
                    // Update existing task
                    Task::where('id', $task_id)->update([
                        'title' => $taskData['title'],
                        'description' => $taskData['description'],
                    ]);
                } else {
                    // Add new task
                    $checklist->tasks()->create([
                        'title' => $taskData['title'],
                        'description' => $taskData['description'],
                    ]);
                }
            }
        }

        // Process deleted tasks
        if ($request->has('deleted_tasks')) {

            $deletedTaskIds = explode(',', $request->deleted_tasks);

            if (count($deletedTaskIds) > 0) {
                Task::whereIn('id', $deletedTaskIds)->delete();
            }
        }

        return redirect()->route('checklists.index', ['trip_plan' => $trip_plan_id])
                        ->with('success', 'Updated Checklist.');
    }

    public function destroy(TripPlan $trip_plan, Checklist $checklist)
    {
        $checklist->delete();

        return redirect()->route('checklists.index', $trip_plan);
    }
}