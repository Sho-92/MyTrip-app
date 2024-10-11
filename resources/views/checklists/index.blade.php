@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="display-4 text-center">Checklist</h1>

    <div class="container border border-dark p-4" style="width: 90%; max-width: 800px; margin-bottom: 50px; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #f9f9f9;">

        <div class="nav nav-tabs" id="myTab" role="tablist">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all" type="button">All</button>
            @foreach ($checklists as $checklist)
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#{{ $checklist->id }}" type="button">{{ $checklist->title }}</button>
            @endforeach
        </div>

        <!-- All -->
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="all">
                @if($checklists->isEmpty())
                    <p style="color: #000;">There is no checklist.</p>
                @else
                    @foreach ($checklists as $checklist)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>{{ $checklist->title ?? 'Check List' }}</h3>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Check</th>
                                            <th>Title</th>
                                            <th>Description</th>
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
                                <div class="text-end mt-2">
                                    <a href="{{ route('checklists.edit', ['trip_plan' => $trip_plan->id, 'checklist' => $checklist->id]) }}" class="mx-2">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="#" class="mx-2" data-bs-toggle="modal" data-bs-target="#deleteChecklistModal" data-checklist-id="{{ $checklist->id }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- each Tasks -->
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
                                        <th>Check</th>
                                        <th>Title</th>
                                        <th>Description</th>
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
                            <div class="text-end mt-2">
                                <a href="{{ route('checklists.edit', ['trip_plan' => $trip_plan->id, 'checklist' => $checklist->id]) }}" class="mx-2">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="#" class="mx-2" data-bs-toggle="modal" data-bs-target="#deleteChecklistModal" data-checklist-id="{{ $checklist->id }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-secondary mx-2" onclick="window.location.href='{{ route('trip_plans.show', $trip_plan->id) }}'">
                    <i class="bi bi-arrow-left-circle" style="margin-right: 5px;"></i>back
                </button>

                <button type="button" class="btn mx-2" style="background: linear-gradient(135deg, #ff7e30, #ffb84d); color: white; border: none;" data-bs-toggle="modal" data-bs-target="#addChecklistModal">
                    <i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Add New
                </button>
            </div>
        </div>
    </div>

    <!-- Additional confirmation modal -->
    <div class="modal fade" id="addChecklistModal" tabindex="-1" aria-labelledby="addChecklistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('checklists.store', ['trip_plan' => $trip_plan->id]) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header" style="color: #000;">
                        <h5 class="modal-title" id="addChecklistModalLabel">Create a New Checklist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color: #000;">
                        <div class="mb-3">
                            <label for="title" class="form-label">Checklist Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete confirmation modal -->
    <div class="modal fade" id="deleteChecklistModal" tabindex="-1" aria-labelledby="deleteChecklistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteChecklistForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header" style="color: #000;">
                        <h5 class="modal-title" id="deleteChecklistModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color: #000;">
                        Are you sure you want to delete this? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


<script>
    const highlightStates = {};

    // Restore checked state from local storage on page load
    document.addEventListener("DOMContentLoaded", function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            const taskRow = checkbox.closest('tr');
            const taskId = taskRow.getAttribute('data-task-id');
            const checklistId = taskRow.closest('.tab-pane').id;
            const savedState = localStorage.getItem(`${checklistId}_${taskId}`);
            if (savedState !== null) {
                checkbox.checked = savedState === 'true';
                toggleHighlight(checkbox);
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
        const checklistId = document.getElementById('checklistFilter').value;
        if (checklistId === "") {
            alert('Please select a checklist.');
            return;
        } else if (checklistId === "all") {
            alert('All checklists are selected. Select a specific checklist to create a task.');
            return;
        }

        window.location.href = `{{ route('tasks.create', ['trip_plan' => $trip_plan->id, 'checklist' => '__CHECKLIST_ID__']) }}`.replace('__CHECKLIST_ID__', checklistId);
    }

    function toggleHighlight(checkbox) {
        const taskRow = checkbox.closest('tr');
        const taskId = taskRow.getAttribute('data-task-id');
        const checklistId = taskRow.closest('.tab-pane').id;

        localStorage.setItem(`${checklistId}_${taskId}`, checkbox.checked);

        if (checkbox.checked) {
            taskRow.classList.add('table-primary');
        } else {
            taskRow.classList.remove('table-primary');
        }

        // Reflected from each task to All tab
        if (checklistId !== 'all') {
            const allTaskRow = document.querySelector(`#all tr[data-task-id="${taskId}"]`);
            if (allTaskRow) {
                const allCheckbox = allTaskRow.querySelector('input[type="checkbox"]');
                if (allCheckbox) {
                    allCheckbox.checked = checkbox.checked;
                    allTaskRow.classList.toggle('table-primary', checkbox.checked);
                }
            }
        }

        // Reflection from All tab to each tab
        if (checklistId === 'all') {
            const taskRowsToUpdate = document.querySelectorAll(`tr[data-task-id="${taskId}"]`);
            taskRowsToUpdate.forEach((row) => {
                const taskCheckbox = row.querySelector('input[type="checkbox"]');
                if (taskCheckbox && row.closest('.tab-pane').id !== 'all') {
                    taskCheckbox.checked = checkbox.checked;
                    row.classList.toggle('table-primary', checkbox.checked);
                    localStorage.setItem(`${row.closest('.tab-pane').id}_${taskId}`, checkbox.checked);
                }
            });
        }
    }

    function addTask(taskId) {
        const newTaskRow = document.createElement('tr');
        newTaskRow.setAttribute('data-task-id', taskId);
        newTaskRow.innerHTML = `
            <td><input type="checkbox" onchange="toggleHighlight(this)"></td>
            <td>New Task</td>
        `;
        document.querySelector('.tab-pane.active tbody').appendChild(newTaskRow);

        const newCheckbox = newTaskRow.querySelector('input[type="checkbox"]');
        newCheckbox.checked = false;
        toggleHighlight(newCheckbox);
    }

    function deleteTask(taskId) {
        const taskRow = document.querySelector(`tr[data-task-id="${taskId}"]`);
        if (taskRow) {
            const checklistId = taskRow.closest('.tab-pane').id;
            taskRow.remove();
            localStorage.removeItem(`${checklistId}_${taskId}`);
        }
    }

    const deleteChecklistModal = document.getElementById('deleteChecklistModal');
    deleteChecklistModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const checklistId = button.getAttribute('data-checklist-id');
        const form = document.getElementById('deleteChecklistForm');
        form.action = `/trip_plans/{{ $trip_plan->id }}/checklists/${checklistId}`;
    });

</script>

@endsection

