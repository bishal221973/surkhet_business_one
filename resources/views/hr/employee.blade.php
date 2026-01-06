@extends('layouts.app')

@section('content')
@section('page-title', 'Employee')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Human Resource</li>
    <li class="breadcrumb-item active" aria-current="page">Employee</li>
@endsection
<div class="app-content">
    <div class="container-fluid">
        <x-table :headers="['#', 'Name', 'Role', 'Phone', 'Salary', 'Joining Date', 'Status', 'Action']">
            <x-slot name="addButtons">
                <x-add-employee :employee="$employee" :roles="$roles" />
            </x-slot>

            @foreach ($employees as $employee)
                <tr>
                    <td><small>{{ $loop->iteration }}</small></td>
                    <td>
                        <div class="d-flex">
                            <img src="{{ $employee?->user?->profile ? asset('storage/' . $employee?->user?->profile) : asset('images/user.png') }}"
                                class="user-image rounded-circle shadow employee-img"
                                alt="{{ auth()?->user()?->name }}" />
                            <div>
                                <small class="d-block">{{ $employee->user->name }}</small>
                                <small class="d-block">{{ $employee->user->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td><small>
                            @if (!$employee?->user?->roles->isEmpty())
                                {{ $employee?->user?->roles[0]?->name }}
                        </small></td>
            @endif
            <td><small>{{ $employee->user->phone }}</small></td>
            <td><small>Rs. {{ $employee->salary }}</small></td>
            <td><small>{{ getFormatedDate($employee->joining_date) }}</small></td>
            <td><input type="checkbox" class="form-check-input employee-status-toggle" data-id="{{ $employee->id }}"
                    {{ $employee->user->status ? 'checked' : '' }}></td>
            <td>
                <div class="d-flex gap-2">
                    <x-edit route="{{ route('employee.edit', $employee->id) }}"/>
                    <x-delete route="{{ route('employee.destroy', $employee->id) }}"/>


                </div>
            </td>
            </tr>
            @endforeach

        </x-table>


    </div>
</div>
@endsection

<script>
    $(document).on('change', '.employee-status-toggle', function() {
        const checkbox = $(this);
        const id = checkbox.data('id');
        const status = checkbox.is(':checked') ? 1 : 0;

        $.ajax({
            url: "{{ route('employee.status.toggle') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                status: status
            },
            success: function(res) {
                const label = checkbox.next('small');
                label.text(status ? 'Active' : 'Inactive');
            },
            error: function() {
                alert('Status update failed');
                checkbox.prop('checked', !status); // rollback
            }
        });
    });
</script>
