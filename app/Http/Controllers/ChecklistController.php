<?php

namespace App\Http\Controllers;
use App\Models\TripPlan;
use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    // チェックリストの一覧を表示
    public function index(TripPlan $trip_plan)
    {

        // 該当の旅行プランに関連するチェックリストを取得
        $checklists = $trip_plan->checklists;

        return view('checklists.index', [
            'trip_plan' => $trip_plan,
            'checklists' => $checklists,
        ]);
    }
    // 新しいチェックリストのフォームを表示
    public function create(TripPlan $trip_plan)
    {
        return view('checklists.create', compact('trip_plan'));
    }

    // 新しいチェックリストを保存
    public function store(Request $request, $trip_plan_id)
    {
        // 入力のバリデーション
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // チェックリストを作成
        $checklist = new Checklist();
        $checklist->title = $request->title;
        $checklist->trip_plan_id = $trip_plan_id;
        $checklist->save();

        // タスクを作成するためのリダイレクト
        return redirect()->route('tasks.create', [
            'trip_plan' => $trip_plan_id,
            'checklist' => $checklist->id
        ]);
    }

    // チェックリストの編集フォームを表示
    public function edit($trip_plan_id, Checklist $checklist)
    {
        return view('checklists.edit', compact('trip_plan_id', 'checklist'));
    }

    // チェックリストを更新
    public function update(Request $request, $trip_plan_id, Checklist $checklist)
    {
        // バリデーション
        $request->validate([
            'title' => 'required|string|max:255',
            // 必要に応じて他のバリデーションルールを追加
        ]);

        // チェックリストのタイトルを更新
        $checklist->update(['title' => $request->title]);

        // タスクがリクエストに存在するかをチェック
        if ($request->has('tasks')) {
            // 既存のタスクを更新または新しいタスクを追加
            foreach ($request->tasks as $task_id => $taskData) {
                if (is_numeric($task_id)) {
                    // 既存タスクを更新
                    Task::where('id', $task_id)->update([
                        'title' => $taskData['title'],
                        'description' => $taskData['description'],
                    ]);
                } else {
                    // 新しいタスクを追加
                    $checklist->tasks()->create([
                        'title' => $taskData['title'],
                        'description' => $taskData['description'],
                    ]);
                }
            }
        }

        // 削除されたタスクを処理
        if ($request->has('deleted_tasks')) {
            // カンマ区切りの文字列を配列に変換
            $deletedTaskIds = explode(',', $request->deleted_tasks);

            // 削除するタスクがある場合、削除を実行
            if (count($deletedTaskIds) > 0) {
                Task::whereIn('id', $deletedTaskIds)->delete();
            }
        }

        // チェックリスト一覧ページにリダイレクト（IDを渡す）
        return redirect()->route('checklists.index', ['trip_plan' => $trip_plan_id])
                        ->with('success', 'チェックリストが更新されました。');
    }


    // チェックリストを削除
    public function destroy(TripPlan $trip_plan, Checklist $checklist)
    {
        $checklist->delete();

        return redirect()->route('checklists.index', $trip_plan);
    }
}