<button class="main-bg border-0 px-3 rounded shadow" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
    <i class="fa fa-plus"></i>
    Add Employee
</button>

<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">{{ $employee?->id ? 'Edit' : 'Add' }} employee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ $employee?->id ? route('employee.update', $employee->id) : route('employee.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method($employee?->id ? 'put' : 'post')
                <div class="modal-body">
                    <div class="row">
                        <x-form.input col="mb-3 col-md-4" required="true"
                            value="{{ old('name', $employee?->user?->name) }}" label="Name" name="name"
                            placeholder="Enter employee name" />

                        <x-form.input col="mb-3 col-md-4" required="true" type="email"
                            value="{{ old('email', $employee?->user?->email) }}" label="Email" name="email"
                            placeholder="Enter employee email" />
                            @if ($employee?->id)

                            <x-form.input col="mb-3 col-md-4" disabled  type="password" required="true"
                                value="Password" label="Password" name="password"
                                placeholder="Enter password" />
                            @else
                                <x-form.input col="mb-3 col-md-4"  type="password" required="true"
                                value="{{ old('password', $employee?->user?->password) }}" label="Password" name="password"
                                placeholder="Enter password" />
                            @endif
                            <div class="mb-3 col-md-3">
                                <label>Role</label>
                                <select name="role" class="form-control form-select">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <x-form.input col="mb-3 col-md-3" required="true"
                            value="{{ old('phone', $employee?->user?->phone) }}" label="Phone" name="phone"
                            placeholder="Enter phone" />
                        <x-form.input col="mb-3 col-md-3" required="true"
                            value="{{ old('salary', $employee?->salary) }}" label="Salary" name="salary"
                            placeholder="Enter salary" />
                        <x-datepicker col="mb-3 col-md-3" required="true"
                            value="{{ old('joining_date', $employee?->joining_date) }}" label="Joining Date"
                            name="joining_date" placeholder="Enter joining date" />
                        <x-form.image-upload col="col-md-12" label="Profile" name="profile" :value="$employee?->user?->profile"
                            default="images/user.png" />

                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn main-bg text-white">
                                {{ $employee?->id ? 'Update' : 'Add' }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@if($employee?->id)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var myModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
                myModal.show();
            });
        </script>
    @endpush
@endif
