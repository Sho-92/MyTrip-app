@extends('layouts.app')

@section('content')
<div class="container">
    <h1>タスクの作成</h1>

    <form action="{{ route('tasks.store', ['trip_plan' => $trip_plan->id, 'checklist' => $checklist->id]) }}" method="POST">
        @csrf

        <table class="table" id="tasksTable">
            <thead>
                <tr>
                    <th scope="col">タスクのタイトル</th>
                    <th scope="col">タスクの説明</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 3; $i++) <!-- 最初に3行用意 -->
                <tr>
                    <td>
                        <input type="text" class="form-control" name="tasks[{{ $i }}][title]" required>
                    </td>
                    <td>
                        <textarea class="form-control" name="tasks[{{ $i }}][description]" rows="2" required></textarea>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-row">削除</button>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>

        <button type="button" id="addRow" class="btn btn-secondary">行を追加</button>
        <button type="submit" class="btn btn-primary">作成</button>
        <a href="{{ route('checklists.index', $trip_plan) }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let rowCount = {{ $i }}; // 最初の行数を設定

        // 行を追加
        document.getElementById('addRow').addEventListener('click', function () {
            const tableBody = document.querySelector('#tasksTable tbody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="tasks[${rowCount}][title]" required></td>
                <td><textarea class="form-control" name="tasks[${rowCount}][description]" rows="2" required></textarea></td>
                <td><button type="button" class="btn btn-danger remove-row">削除</button></td>
            `;
            tableBody.appendChild(newRow);
            rowCount++;
        });

        // 行を削除
        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-row')) {
                const row = e.target.closest('tr');
                row.remove();
            }
        });
    });
</script>
@endsection
