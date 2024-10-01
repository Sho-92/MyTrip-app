@extends('layouts.app')

@section('content')
<div class="container">
    <h1>チェックリスト</h1>

    <!-- チェックリスト追加ボタン -->
    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addChecklistModal">
        チェックリストを追加
    </button>

    <!-- チェックリストのタブ -->
    <div class="nav nav-tabs" id="myTab" role="tablist">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all" type="button">All</button>
        @foreach ($checklists as $checklist)
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#{{ $checklist->id }}" type="button">{{ $checklist->title }}</button>
        @endforeach
    </div>

    <!-- Allの内容 -->
    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="all">
            @if($checklists->isEmpty())
                <p>チェックリストがありません。追加してください。</p>
            @else
                @foreach ($checklists as $checklist)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3>{{ $checklist->title }}</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>チェック</th>
                                        <th>タスクのタイトル</th>
                                        <th>タスクの説明</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($checklist->tasks as $task)
                                        <tr data-task-id="{{ $task->id }}" data-checklist-id="{{ $checklist->id }}" class="@if($task->is_checked) table-success @endif">
                                            <td>
                                                <input type="checkbox" class="form-check-input" @if($task->is_checked) checked @endif onchange="toggleHighlight(this)">
                                            </td>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ $task->description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- 各チェックリストの編集ボタン -->
                        <a href="{{ route('checklists.edit', ['trip_plan' => $trip_plan->id, 'checklist' => $checklist->id]) }}" class="btn btn-warning">編集</a>
                        <!-- 各チェックリストの削除ボタン -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteChecklistModal" data-checklist-id="{{ $checklist->id }}">
                            削除
                        </button>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- 各Tasksの内容 -->
        @foreach ($checklists as $checklist)
            <div class="tab-pane fade" id="{{ $checklist->id }}">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3>{{ $checklist->title }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>チェック</th>
                                    <th>タスクのタイトル</th>
                                    <th>タスクの説明</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($checklist->tasks as $task)
                                    <tr data-task-id="{{ $task->id }}" data-checklist-id="{{ $checklist->id }}" class="@if($task->is_checked) table-success @endif">
                                        <td>
                                            <input type="checkbox" class="form-check-input" @if($task->is_checked) checked @endif onchange="toggleHighlight(this)">
                                        </td>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- 各チェックリストの編集ボタン -->
                    <a href="{{ route('checklists.edit', ['trip_plan' => $trip_plan->id, 'checklist' => $checklist->id]) }}" class="btn btn-warning">編集</a>
                    <!-- 各チェックリストの削除ボタン -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteChecklistModal" data-checklist-id="{{ $checklist->id }}">
                        削除
                    </button>
                </div>
            </div>
        @endforeach
        <a href="{{ route('trip_plans.show', $trip_plan) }}" class="btn btn-secondary">戻る</a>

    </div>


    <!-- チェックリスト追加モーダル -->
    <div class="modal fade" id="addChecklistModal" tabindex="-1" aria-labelledby="addChecklistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('checklists.store', ['trip_plan' => $trip_plan->id]) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addChecklistModalLabel">新しいチェックリストを追加</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">チェックリストのタイトル</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                        <button type="submit" class="btn btn-primary">追加</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 削除確認モーダル -->
    <div class="modal fade" id="deleteChecklistModal" tabindex="-1" aria-labelledby="deleteChecklistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteChecklistForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteChecklistModalLabel">チェックリストの削除確認</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        このチェックリストを本当に削除しますか？この操作は取り消せません。
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                        <button type="submit" class="btn btn-danger">削除</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


<script>
    const highlightStates = {}; // ハイライト状態を格納するオブジェクト

    // ページロード時にローカルストレージからチェック状態を復元
    document.addEventListener("DOMContentLoaded", function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            const taskRow = checkbox.closest('tr');
            const taskId = taskRow.getAttribute('data-task-id'); // タスクのIDを取得
            const checklistId = taskRow.closest('.tab-pane').id; // チェックリストのIDを取得
            const savedState = localStorage.getItem(`${checklistId}_${taskId}`);
            if (savedState !== null) {
                checkbox.checked = savedState === 'true'; // 状態を復元
                toggleHighlight(checkbox); // ハイライトを更新
            }
        });
    });

    function filterChecklists() {
        const selectedValue = document.getElementById('checklistFilter').value;
        const allTabs = document.querySelectorAll('.tab-pane');

        allTabs.forEach(tab => {
            if (selectedValue === 'all' || tab.id === selectedValue) {
                tab.classList.add('show', 'active');
            } else {
                tab.classList.remove('show', 'active');
            }
        });
    }

    function redirectToCreateTask() {
        const checklistId = document.getElementById('checklistFilter').value; // 選択されたチェックリストのIDを取得
        if (checklistId === "") {
            alert('チェックリストを選択してください。'); // 空の選択肢が選ばれた場合
            return;
        } else if (checklistId === "all") {
            alert('すべてのチェックリストが選択されました。タスクを作成するには、特定のチェックリストを選択してください。');
            return;
        }
        // URLを正しく構成する
        window.location.href = `{{ route('tasks.create', ['trip_plan' => $trip_plan->id, 'checklist' => '__CHECKLIST_ID__']) }}`.replace('__CHECKLIST_ID__', checklistId);
    }

    function toggleHighlight(checkbox) {
        const taskRow = checkbox.closest('tr'); // チェックボックスがある行を取得
        const taskId = taskRow.getAttribute('data-task-id'); // タスクのIDを取得
        const checklistId = taskRow.closest('.tab-pane').id; // チェックリストのIDを取得

        // チェック状態をローカルストレージに保存
        localStorage.setItem(`${checklistId}_${taskId}`, checkbox.checked);

        // 行をハイライト（緑色）
        if (checkbox.checked) {
            taskRow.classList.add('table-success');
        } else {
            taskRow.classList.remove('table-success');
        }

        // 各タスクから All タブへ反映
        if (checklistId !== 'all') {
            const allTaskRow = document.querySelector(`#all tr[data-task-id="${taskId}"]`);
            if (allTaskRow) {
                const allCheckbox = allTaskRow.querySelector('input[type="checkbox"]');
                if (allCheckbox) {
                    allCheckbox.checked = checkbox.checked; // Allタブのチェックボックスを更新
                    allTaskRow.classList.toggle('table-success', checkbox.checked); // Allタブのハイライトを更新
                }
            }
        }

        // All タブから各タブへの反映
        if (checklistId === 'all') {
            const taskRowsToUpdate = document.querySelectorAll(`tr[data-task-id="${taskId}"]`);
            taskRowsToUpdate.forEach((row) => {
                const taskCheckbox = row.querySelector('input[type="checkbox"]');
                if (taskCheckbox && row.closest('.tab-pane').id !== 'all') {
                    taskCheckbox.checked = checkbox.checked; // 他のタブのチェックボックスを更新
                    row.classList.toggle('table-success', checkbox.checked); // ハイライトの状態を更新
                    localStorage.setItem(`${row.closest('.tab-pane').id}_${taskId}`, checkbox.checked); // 更新をローカルストレージにも反映
                }
            });
        }
    }

    // 新しいタスクを追加する関数
    function addTask(taskId) {
        const newTaskRow = document.createElement('tr');
        newTaskRow.setAttribute('data-task-id', taskId);
        newTaskRow.innerHTML = `
            <td><input type="checkbox" onchange="toggleHighlight(this)"></td>
            <td>新しいタスク</td>
        `;
        document.querySelector('.tab-pane.active tbody').appendChild(newTaskRow);

        // 新しいタスクのチェックボックスを初期化
        const newCheckbox = newTaskRow.querySelector('input[type="checkbox"]');
        newCheckbox.checked = false; // 初期状態は未チェック
        toggleHighlight(newCheckbox); // 初期状態に基づいてハイライトを設定
    }

    // タスクを削除する関数
    function deleteTask(taskId) {
        const taskRow = document.querySelector(`tr[data-task-id="${taskId}"]`);
        if (taskRow) {
            const checklistId = taskRow.closest('.tab-pane').id; // チェックリストのIDを取得
            taskRow.remove(); // 行を削除
            localStorage.removeItem(`${checklistId}_${taskId}`); // ローカルストレージからも削除
        }
    }

    // JavaScriptで削除するチェックリストのIDをモーダルに設定
    const deleteChecklistModal = document.getElementById('deleteChecklistModal');
    deleteChecklistModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // モーダルを開いたボタン
        const checklistId = button.getAttribute('data-checklist-id'); // チェックリストのIDを取得
        const form = document.getElementById('deleteChecklistForm'); // 削除フォーム
        form.action = `/trip_plans/{{ $trip_plan->id }}/checklists/${checklistId}`; // 削除フォームのアクションを設定
    });

</script>

@endsection

