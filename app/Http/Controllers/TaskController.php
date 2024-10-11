<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\TripPlan;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(TripPlan $tripPlan, Checklist $checklist)
    {
        $tasks = $checklist->tasks()->get();
        return view('tasks.index', compact('checklist', 'tasks'));
    }

    public function create(TripPlan $tripPlan, Checklist $checklist)
    {
        return view('tasks.create', compact('tripPlan', 'checklist'));
    }

    public function store(Request $request, TripPlan $tripPlan, Checklist $checklist)
    {
        $request->validate([
            'tasks.*.title' => 'required|string|max:255',
            'tasks.*.description' => 'required|string|max:255',
        ]);

        foreach ($request->tasks as $taskData) {
            $checklist->tasks()->create([
                'title' => $taskData['title'],
                'description' => $taskData['description'],
                'is_checked' => isset($taskData['is_checked']) ? $taskData['is_checked'] : false,
                'checklist_id' => $checklist->id,
            ]);
        }

        return redirect()->route('checklists.index', $tripPlan->id)
                        ->with('success', 'Added Task.');
    }

    public function edit(Checklist $checklist, Task $task)
    {
        return view('tasks.edit', compact('checklist', 'task'));
    }

    public function update(Request $request, TripPlan $tripPlan, Checklist $checklist, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_checked' => $request->has('is_checked'),
        ]);

        return redirect()->route('trip_plans.checklists.index', [$tripPlan->id, $checklist->id])
                     ->with('success', 'Added Task.');
    }

    public function destroy(TripPlan $tripPlan, Checklist $checklist, Task $task)
    {
        $task->delete();

        return redirect()->route('trip_plans.checklists.index', [$tripPlan, $checklist]);
    }
}