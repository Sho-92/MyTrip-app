@extends('layouts.app')

@section('content')
<h1 class="display-4 text-center">Create a New Task</h1>
<div class="container border border-dark p-4" style="width: 80%; max-width: 800px; margin-bottom: 50px; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #f9f9f9;">
    <form action="{{ route('tasks.store', ['trip_plan' => $tripPlan->id, 'checklist' => $checklist->id]) }}" method="POST">
        @csrf

        <table class="table" id="tasksTable">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 3; $i++)
                <tr>
                    <td>
                        <input type="text" class="form-control" name="tasks[{{ $i }}][title]" required>
                    </td>
                    <td>
                        <textarea class="form-control" name="tasks[{{ $i }}][description]" rows="2" required></textarea>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-row">Delete</button>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <a href="{{ route('checklists.index', $tripPlan) }}" class="btn btn-secondary mx-2"><i class="bi bi-x-circle" style="margin-right: 5px;"></i>Cansell</a>
            <button type="submit" class="btn btn-primary mx-2"> Create </button>
            <button type="button" id="addRow" class="btn btn-secondary mx-2"><i class="bi bi-plus-circle" style="margin-right: 5px;"></i> Add More Rows </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let rowCount = {{ $i }};

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

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-row')) {
                const row = e.target.closest('tr');
                row.remove();
            }
        });
    });
</script>
@endsection
