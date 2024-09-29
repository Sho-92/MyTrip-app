@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $checklist->title }} の編集</h1>

    <form action="{{ route('checklists.update', ['trip_plan' => $trip_plan_id, 'checklist' => $checklist->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- チェックリストのタイトル編集 -->
        <div class="mb-3">
            <label for="title" class="form-label">チェックリストのタイトル</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $checklist->title }}" required>
        </div>

        <!-- 削除されたタスクのIDを保持するhiddenフィールド -->
        <input type="hidden" name="deleted_tasks" id="deleted_tasks">

        <!-- タスクのテーブル -->
        <table class="table" id="tasksTable">
            <thead>
                <tr>
                    <th>タスクのタイトル</th>
                    <th>タスクの説明</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($checklist->tasks as $task)
                <tr data-task-id="{{ $task->id }}">
                    <td>
                        <input type="text" class="form-control" name="tasks[{{ $task->id }}][title]" value="{{ $task->title }}" required>
                    </td>
                    <td>
                        <textarea class="form-control" name="tasks[{{ $task->id }}][description]" rows="2" required>{{ $task->description }}</textarea>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-row" data-task-id="{{ $task->id }}">削除</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" id="addRow" class="btn btn-secondary">行を追加</button>
        <button type="submit" class="btn btn-primary">保存</button>
        <a href="{{ route('checklists.index', $trip_plan_id) }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let rowCount = {{ count($checklist->tasks) }}; // 既存の行数を設定
        let deletedTaskIds = []; // 削除されたタスクIDを保持する配列

        // 行を追加
        document.getElementById('addRow').addEventListener('click', function () {
            const tableBody = document.querySelector('#tasksTable tbody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="tasks[new_${rowCount}][title]" required></td>
                <td><textarea class="form-control" name="tasks[new_${rowCount}][description]" rows="2" required></textarea></td>
                <td><button type="button" class="btn btn-danger remove-row">削除</button></td>
            `;
            tableBody.appendChild(newRow);
            rowCount++;
        });

        // 行を削除
        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-row')) {
                const row = e.target.closest('tr');
                const taskId = row.getAttribute('data-task-id');

                // タスクIDが存在する場合は削除リストに追加
                if (taskId) {
                    deletedTaskIds.push(taskId);
                    document.getElementById('deleted_tasks').value = deletedTaskIds.join(',');
                }

                // 行を削除
                row.remove();
            }
        });
    });
</script>
@endsection
