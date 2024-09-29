<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\TripPlan;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // タスクの一覧を表示
    public function index(Checklist $checklist)
    {
        // 特定のchecklistに属するtasksを取得
        $tasks = $checklist->tasks()->get();
        return view('tasks.index', compact('checklist', 'tasks'));
    }

    // 新しいタスクのフォームを表示
    public function create($trip_plan_id, $checklist_id)
    {
        $trip_plan = TripPlan::findOrFail($trip_plan_id);
        $checklist = Checklist::findOrFail($checklist_id); // ここでIDからチェックリストを取得

        // ビューに必要なデータを渡す
        return view('tasks.create', compact('trip_plan', 'checklist'));
    }

    // 新しいタスクを保存
    public function store(Request $request, $trip_plan_id, Checklist $checklist)
    {
        // 各タスクのバリデーション
        $request->validate([
            'tasks.*.title' => 'required|string|max:255',
            'tasks.*.description' => 'required|string|max:255',
        ]);

        // 各タスクを保存
        foreach ($request->tasks as $taskData) {
            $checklist->tasks()->create([
                'title' => $taskData['title'],
                'description' => $taskData['description'],
                'is_checked' => isset($taskData['is_checked']) ? $taskData['is_checked'] : false,
            ]);
        }

        // インデックスページにリダイレクト
        return redirect()->route('checklists.index', $trip_plan_id)
                        ->with('success', 'タスクが追加されました。');
    }

    // タスクの編集フォームを表示
    public function edit(Checklist $checklist, Task $task)
    {
        return view('tasks.edit', compact('checklist', 'task'));
    }

    // タスクを更新
    public function update(Request $request, Checklist $checklist, Task $task)
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

        return redirect()->route('checklists.show', $checklist->id)
                     ->with('success', 'タスクが追加されました。');
    }

    // タスクを削除
    public function destroy(Checklist $checklist, Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index', $checklist);
    }
}
