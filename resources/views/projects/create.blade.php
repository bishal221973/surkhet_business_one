@extends('layouts.app')

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
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <x-form.input required="true" col="mb-3 col-md-3" label="Project name" name="project_name"
                            placeholder="Project name" />

                        <x-datepicker required="true" col="mb-3 col-md-3" label="Start date" name="start_date"
                            placeholder="Start date" />

                        <div class="col-md-3">
                            <label>Status <span>*</span></label>
                            <select name="status" class="form-control form-select" required>
                                <option value="">Select status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
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
                                <tbody></tbody>
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
            <td><button type="button" class="btn btn-sm btn-danger">Delete</button></td>
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
            tr.querySelector('button').addEventListener('click', () => {
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
@endpush
