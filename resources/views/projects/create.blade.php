{{-- @extends('layouts.app')

@section('page-title', 'New Project')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Project</li>
    <li class="breadcrumb-item active" aria-current="page">New Project</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Client -->
                        <div class="col-md-3">
                            <label>Client <span>*</span></label>
                            <select name="client_id" class="form-control form-select" required>
                                <option value="">Select client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ $project->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <x-form.input required="true" col="mb-3 col-md-3" label="Project name" name="project_name"
                            placeholder="Project name" value="{{ old('project_name', $project->project_name) }}" />

                        <x-datepicker required="true" value="{{ old('start_date', $project->start_date) }}"
                            col="mb-3 col-md-3" label="Start date" name="start_date" placeholder="Start date" />

                        <div class="col-md-3">
                            <label>Status <span>*</span></label>
                            <select name="status" class="form-control form-select" required>
                                <option value="">Select status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ $project->status == $status ? 'selected' : '' }}>
                                        {{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tasks Table -->
                        <div class="col-12 mt-3">
                            <table class="w-100 table table-bordered" id="tasksTable">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Title</th>
                                        <th>Priority</th>
                                        <th>Deadline</th>
                                        <th>Assigned To</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->tasks as $task)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ $task->priority }}</td>
                                            <td>{{ $task->deadline }}</td>
                                            <td>
                                                @php
                                                    // Collect all assigned user IDs for this project/item
                                                    $allUserIds = collect();
                                                    foreach ($task?->assigned_to as $assigned) {
                                                        $allUserIds = $allUserIds->merge($assigned ?? []);
                                                    }

                                                    // Remove duplicates
                                                    $uniqueUserIds = $allUserIds->unique();

                                                    // Fetch user models once
                                                    $users = \App\Models\User::whereIn('id', $uniqueUserIds)->get();
                                                @endphp
                                                @foreach ($users as $user)
                                                    <span>{{ $user->name }}</span>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </td>
                                             <td>{{ $task->status }}</td>
                                             <td>{{ $task->description }}</td>
                                             <td><button type="button" class="btn btn-sm btn-danger delete-task">Delete</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Buttons -->
                        <div class="col-12 mt-3">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#addTaskModal">Add Task</button>
                                <button type="submit" class="btn btn-sm btn-primary">Save Project</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="taskForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Task Title <span>*</span></label>
                            <input type="text" class="form-control" id="task_title" required>
                        </div>

                        <div class="mb-3">
                            <label>Priority <span>*</span></label>
                            <select class="form-control" id="priority" required>
                                <option value="">Select priority</option>
                                @foreach ($taskPriority as $priority)
                                    <option value="{{ $priority }}">{{ $priority }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Deadline <span>*</span></label>
                            <input type="date" class="form-control" id="deadline" required>
                        </div>

                        <div class="mb-3">
                            <label>Assigned To <span>*</span></label>
                            <select class="select" multiple id="assigned_to" required>
                                <option value="">Select Staff</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">

                            <label>Status <span>*</span></label>
                            <select class="form-control" id="task_status" required>
                                <option value="">Select Status</option>
                                @foreach ($taskStatuses as $taskStatus)
                                    <option value="{{ $taskStatus }}">{{ $taskStatus }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Remarks</label>
                            <textarea class="form-control" id="remarks"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addTaskBtn">Add Task</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const tasks = [];
        const tbody = document.querySelector('#tasksTable tbody');
        const addTaskBtn = document.getElementById('addTaskBtn');

        addTaskBtn.addEventListener('click', () => {
            const title = document.getElementById('task_title').value;
            const priority = document.getElementById('priority').value;
            const deadline = document.getElementById('deadline').value;

            const assignedSelect = document.getElementById('assigned_to');
            // const assigned_to = document.getElementById('assigned_to').value;
            // const assigned_name = document.getElementById('assigned_to').selectedOptions[0].text;
            const assigned_to = JSON.stringify(Array.from(assignedSelect.selectedOptions).map(o => o.value));
            const assigned_names = Array.from(assignedSelect.selectedOptions).map(o => o.text).join(', ');

            const status = document.getElementById('task_status').value;
            const remarks = document.getElementById('remarks').value;

            if (!title || !priority || !deadline || !assigned_to || !status) {
                alert("Please fill all required fields!");
                return;
            }

            const task = {
                title,
                priority,
                deadline,
                assigned_to,
                status,
                remarks
            };
            tasks.push(task);

            // Append row to table
            const rowIndex = tbody.rows.length;
            const tr = document.createElement('tr');
            tr.innerHTML = `
            <td>${rowIndex + 1}</td>
            <td>${title}</td>
            <td>${priority}</td>
            <td>${deadline}</td>
            <td>${assigned_names}</td>
            <td>${status}</td>
            <td>${remarks}</td>
            <td><button type="button" class="btn btn-sm btn-danger delete-task">Delete</button></td>
        `;
            tbody.appendChild(tr);

            // Hidden inputs for form submission
            const form = document.querySelector('form[action="{{ route('project.store') }}"]');

            const inputFields = ['title', 'priority', 'deadline', 'assigned_to', 'status', 'remarks'];
            inputFields.forEach(field => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `tasks[${rowIndex}][${field}]`;
                input.value = task[field];
                form.appendChild(input);
            });

            // Delete functionality
            tr.querySelector('.delete-task').addEventListener('click', () => {
                tasks.splice(rowIndex, 1);
                tr.remove();
                // Remove hidden inputs for this task
                inputFields.forEach(field => {
                    const input = form.querySelector(`input[name="tasks[${rowIndex}][${field}]"]`);
                    if (input) input.remove();
                });
                updateTableIndex();
            });

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addTaskModal'));
            modal.hide();
            document.getElementById('taskForm').reset();
        });

        function updateTableIndex() {
            Array.from(tbody.rows).forEach((row, i) => row.cells[0].innerText = i + 1);
        }
    </script>
@endpush --}}
{{-- ============================================= --}}
{{-- @extends('layouts.app')

@section('page-title', 'New Project')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Project</li>
    <li class="breadcrumb-item active" aria-current="page">New Project</li>
@endsection

@section('content')
<div class="app-content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data" id="projectForm">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label>Client <span>*</span></label>
                        <select name="client_id" class="form-control form-select" required>
                            <option value="">Select client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ $project->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <x-form.input required="true" col="mb-3 col-md-3" label="Project name" name="project_name"
                        placeholder="Project name" value="{{ old('project_name', $project->project_name) }}" />

                    <x-datepicker required="true" value="{{ old('start_date', $project->start_date) }}"
                        col="mb-3 col-md-3" label="Start date" name="start_date" placeholder="Start date" />

                    <div class="col-md-3">
                        <label>Status <span>*</span></label>
                        <select name="status" class="form-control form-select" required>
                            <option value="">Select status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ $project->status == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mt-3">
                        <table class="w-100 table table-bordered" id="tasksTable">
                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    <th>Title</th>
                                    <th>Priority</th>
                                    <th>Deadline</th>
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->tasks as $index => $task)
                                    <tr data-index="{{ $index }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->priority }}</td>
                                        <td>{{ $task->deadline }}</td>
                                        <td>
                                            @php
                                                $userIds = collect($task->assigned_to)->flatten()->unique();
                                                $users = \App\Models\User::whereIn('id', $userIds)->get();
                                            @endphp
                                            {{ $users->pluck('name')->implode(', ') }}
                                        </td>
                                        <td>{{ $task->status }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td><button type="button" class="btn btn-sm btn-danger delete-task">Delete</button></td>
                                        <input type="hidden" name="tasks[{{ $index }}][title]" value="{{ $task->title }}">
                                        <input type="hidden" name="tasks[{{ $index }}][priority]" value="{{ $task->priority }}">
                                        <input type="hidden" name="tasks[{{ $index }}][deadline]" value="{{ $task->deadline }}">
                                        <input type="hidden" name="tasks[{{ $index }}][assigned_to]" value='@json($task->assigned_to)'>
                                        <input type="hidden" name="tasks[{{ $index }}][status]" value="{{ $task->status }}">
                                        <input type="hidden" name="tasks[{{ $index }}][remarks]" value="{{ $task->description }}">
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#addTaskModal">Add Task</button>
                            <button type="submit" class="btn btn-sm btn-primary">Save Project</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="taskForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Task Title <span>*</span></label>
                        <input type="text" class="form-control" id="task_title" required>
                    </div>
                    <div class="mb-3">
                        <label>Priority <span>*</span></label>
                        <select class="form-control" id="priority" required>
                            <option value="">Select priority</option>
                            @foreach ($taskPriority as $priority)
                                <option value="{{ $priority }}">{{ $priority }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Deadline <span>*</span></label>
                        <input type="date" class="form-control" id="deadline" required>
                    </div>
                    <div class="mb-3">
                        <label>Assigned To <span>*</span></label>
                        <select class="select" multiple id="assigned_to" required>
                            <option value="">Select Staff</option>
                            @foreach ($staffs as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status <span>*</span></label>
                        <select class="form-control" id="task_status" required>
                            <option value="">Select Status</option>
                            @foreach ($taskStatuses as $taskStatus)
                                <option value="{{ $taskStatus }}">{{ $taskStatus }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Remarks</label>
                        <textarea class="form-control" id="remarks"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addTaskBtn">Add Task</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector('#tasksTable tbody');
    const addTaskBtn = document.getElementById('addTaskBtn');
    const form = document.getElementById('projectForm');

    function updateTableIndex() {
        Array.from(tbody.rows).forEach((row, i) => {
            row.cells[0].innerText = i + 1;
            row.dataset.index = i;
            row.querySelectorAll('input[type="hidden"]').forEach(input => {
                input.dataset.index = i;
                input.name = input.name.replace(/\d+/, i);
            });
        });
    }

    tbody.addEventListener('click', (e) => {
        if (!e.target.classList.contains('delete-task')) return;
        const row = e.target.closest('tr');
        row.remove();
        row.querySelectorAll('input[type="hidden"]').forEach(input => input.remove());
        updateTableIndex();
    });

    addTaskBtn.addEventListener('click', () => {
        const title = document.getElementById('task_title').value;
        const priority = document.getElementById('priority').value;
        const deadline = document.getElementById('deadline').value;
        const assignedSelect = document.getElementById('assigned_to');
        const assigned_to = Array.from(assignedSelect.selectedOptions).map(o => o.value);
        const assigned_names = Array.from(assignedSelect.selectedOptions).map(o => o.text).join(', ');
        const status = document.getElementById('task_status').value;
        const remarks = document.getElementById('remarks').value;

        if (!title || !priority || !deadline || !assigned_to.length || !status) {
            alert("Please fill all required fields!");
            return;
        }

        const rowIndex = tbody.rows.length;
        const tr = document.createElement('tr');
        tr.dataset.index = rowIndex;

        tr.innerHTML = `
            <td>${rowIndex + 1}</td>
            <td>${title}</td>
            <td>${priority}</td>
            <td>${deadline}</td>
            <td>${assigned_names}</td>
            <td>${status}</td>
            <td>${remarks}</td>
            <td><button type="button" class="btn btn-sm btn-danger delete-task">Delete</button></td>
        `;

        tbody.appendChild(tr);

        const fields = ['title','priority','deadline','assigned_to','status','remarks'];
        fields.forEach(f => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `tasks[${rowIndex}][${f}]`;
            input.value = f === 'assigned_to' ? JSON.stringify(assigned_to) : eval(f);
            input.dataset.index = rowIndex;
            tr.appendChild(input);
        });

        bootstrap.Modal.getInstance(document.getElementById('addTaskModal')).hide();
        document.getElementById('taskForm').reset();
    });
});
</script>
@endpush --}}
@extends('layouts.app')

@section('page-title', 'New Project')

@section('content')
    <div class="app-content">
        <div class="card">
            <div class="card-body">

                <form action="{{ $project->id ? route('project.update', $project->id) : route('project.store') }}" method="POST" id="projectForm">
                    @csrf
                    @method('put')

                    <div class="row">

                        <!-- Client -->
                        <div class="col-md-3 mb-3">
                            <label>Client *</label>
                            <select name="client_id" class="form-control" required>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ $project->client_id == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-form.input required="true" col="mb-3 col-md-3" label="Project name" name="project_name"
                            placeholder="Project name" value="{{ old('project_name', $project->project_name) }}" />

                        <x-datepicker required="true" value="{{ old('start_date', $project->start_date) }}"
                            col="mb-3 col-md-3" label="Start date" name="start_date" placeholder="Start date" />

                        <div class="col-md-3">
                            <label>Status <span>*</span></label>
                            <select name="status" class="form-control form-select" required>
                                <option value="">Select status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ $project->status == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mt-3">
                            <table class="table table-bordered" id="tasksTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Priority</th>
                                        <th>Deadline</th>
                                        <th>Assigned</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($project->tasks as $i => $task)
                                        <tr data-index="{{ $i }}">
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ $task->priority }}</td>
                                            <td>{{ $task->deadline }}</td>
                                            <td>
                                                {{ \App\Models\User::whereIn('id', collect($task->assigned_to)->flatten())->pluck('name')->implode(', ') }}
                                            </td>
                                            <td>{{ $task->status }}</td>
                                            <td>{{ $task->description }}</td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-sm btn-warning edit-task">Edit</button>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger delete-task">Delete</button>
                                            </td>
                                             <input type="hidden" name="tasks[{{ $i }}][id]"
                                                value="{{ $task->id }}">
                                            <input type="hidden" name="tasks[{{ $i }}][title]"
                                                value="{{ $task->title }}">
                                            <input type="hidden" name="tasks[{{ $i }}][priority]"
                                                value="{{ $task->priority }}">
                                            <input type="hidden" name="tasks[{{ $i }}][deadline]"
                                                value="{{ $task->deadline }}">
                                            <input type="hidden" name="tasks[{{ $i }}][assigned_to]"
                                                value='@json($task->assigned_to)'>
                                            <input type="hidden" name="tasks[{{ $i }}][status]"
                                                value="{{ $task->status }}">
                                            <input type="hidden" name="tasks[{{ $i }}][remarks]"
                                                value="{{ $task->description }}">
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <div class="col-12 mt-3 text-end">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#taskModal">Add Task</button>
                            <button class="btn btn-primary">Save Project</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="taskModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Task</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="editingIndex">

                    <div class="mb-2">
                        <label>Title *</label>
                        <input id="task_title" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Priority *</label>
                        <select id="priority" class="form-control">
                            @foreach ($taskPriority as $p)
                                <option value="{{ $p }}">{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Deadline *</label>
                        <input type="date" id="deadline" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Assigned *</label>
                        <select id="assigned_to" class="select" multiple>
                            @foreach ($staffs as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Status *</label>
                        <select id="task_status" class="form-control">
                            @foreach ($taskStatuses as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Remarks</label>
                        <textarea id="remarks" class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="saveTask">Save</button>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const tbody = document.querySelector('#tasksTable tbody');
            const modal = new bootstrap.Modal(document.getElementById('taskModal'));

            const getAssignedIds = (value) => {
                try {
                    let parsed = JSON.parse(value);
                    if (typeof parsed === 'string') parsed = JSON.parse(parsed);
                    return parsed.map(v => v.toString());
                } catch {
                    return value.split(',').map(v => v.trim());
                }
            };

            // EDIT
            tbody.addEventListener('click', e => {
                if (!e.target.classList.contains('edit-task')) return;

                const row = e.target.closest('tr');
                document.getElementById('editingIndex').value = row.dataset.index;

                task_title.value = row.cells[1].innerText;
                priority.value = row.cells[2].innerText;
                deadline.value = row.cells[3].innerText;
                task_status.value = row.cells[5].innerText;
                remarks.value = row.cells[6].innerText;

                // assigned users
                const hidden = row.querySelector('input[name*="[assigned_to]"]');
                const ids = getAssignedIds(hidden.value);

                // reset selection
                Array.from(assigned_to.options).forEach(o => {
                    o.selected = ids.includes(o.value);
                });

                let assignedIds = [];

                try {
                    assignedIds = JSON.parse(hidden.value).map(String);
                } catch {
                    assignedIds = [];
                }

                assignedTom.clear(true);
                assignedTom.setValue(assignedIds);
                modal.show();
            });

            // DELETE
            tbody.addEventListener('click', e => {
                if (!e.target.classList.contains('delete-task')) return;
                e.target.closest('tr').remove();
            });

            // SAVE
            saveTask.onclick = () => {

                const ids = [...assigned_to.selectedOptions].map(o => o.value);
                const names = [...assigned_to.selectedOptions].map(o => o.text).join(', ');

                let index = editingIndex.value;
                let row;

                if (index !== "") {
                    row = tbody.querySelector(`tr[data-index="${index}"]`);
                } else {
                    index = tbody.rows.length;
                    row = tbody.insertRow();
                    row.dataset.index = index;
                    row.innerHTML = `<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    <td>
        <button class="btn btn-sm btn-warning edit-task">Edit</button>
        <button class="btn btn-sm btn-danger delete-task">Delete</button>
    </td>`;
                }

                row.cells[0].innerText = +index + 1;
                row.cells[1].innerText = task_title.value;
                row.cells[2].innerText = priority.value;
                row.cells[3].innerText = deadline.value;
                row.cells[4].innerText = names;
                row.cells[5].innerText = task_status.value;
                row.cells[6].innerText = remarks.value;

                row.querySelectorAll('input').forEach(i => i.remove());

                const data = {
                    title: task_title.value,
                    priority: priority.value,
                    deadline: deadline.value,
                    assigned_to: JSON.stringify(ids),
                    status: task_status.value,
                    remarks: remarks.value
                };

                Object.keys(data).forEach(k => {
                    const i = document.createElement('input');
                    i.type = 'hidden';
                    i.name = `tasks[${index}][${k}]`;
                    i.value = data[k];
                    row.appendChild(i);
                });

                editingIndex.value = "";
                modal.hide();
                taskForm.reset();
            };

        });
    </script>
@endpush
