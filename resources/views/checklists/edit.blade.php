@extends('layouts.app')

@section('content')
    <h1 class="display-4 text-center">Editing your {{ $checklist->title }}</h1>
    <div class="container border border-dark p-4" style="width: 80%; max-width: 800px; margin-bottom: 50px; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #f9f9f9;">

        <form action="{{ route('checklists.update', ['trip_plan' => $trip_plan_id, 'checklist' => $checklist->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="border border-dark p-4" style="color: #000000;">
                <input type="text" class="form-control" id="title" name="title" value="{{ $checklist->title }}" required>
                <br>
                <!-- Preserve the ID of deleted tasks -->
                <input type="hidden" name="deleted_tasks" id="deleted_tasks">

                <table class="table" id="tasksTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th></th>
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
                                <button type="button" class="btn btn-danger remove-row" data-task-id="{{ $task->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary mx-2" onclick="window.history.back()">
                        <i class="bi bi-arrow-left-circle" style="margin-right: 5px;"></i>back
                    </button>

                    <button type="submit" class="btn btn-primary mx-2"> Save </button>
                    <button type="button" id="addRow" class="btn btn-secondary mx-2"><i class="bi bi-plus-circle" style="margin-right: 5px;"></i> Add More Rows </button>
                </div>
            </div>
        </form>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let rowCount = {{ count($checklist->tasks) }};
        let deletedTaskIds = [];

        document.getElementById('addRow').addEventListener('click', function () {
            const tableBody = document.querySelector('#tasksTable tbody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="tasks[new_${rowCount}][title]" required></td>
                <td><textarea class="form-control" name="tasks[new_${rowCount}][description]" rows="2" required></textarea></td>
                <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
            `;
            tableBody.appendChild(newRow);
            rowCount++;
        });

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-row')) {
                const row = e.target.closest('tr');
                const taskId = row.getAttribute('data-task-id');

                if (taskId) {
                    deletedTaskIds.push(taskId);
                    document.getElementById('deleted_tasks').value = deletedTaskIds.join(',');
                }

                row.remove();
            }
        });
    });
</script>
@endsection
