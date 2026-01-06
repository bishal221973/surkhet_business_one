@extends('layouts.app')

@section('content')
@section('page-title', 'Permission')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Human Resource</li>
    <li class="breadcrumb-item active" aria-current="page">Permission</li>
@endsection

<div class="app-content">
    <div class="container-fluid">
        <div class="card shadow1">
            <div class="card-header py-2" style="background-color: #C9DBE8">
                <div class="d-flex justify-content-between align-items-center">
                    <div>{{ $role->name }} ({{ $role->permissions->count() }} Permissions)</div>
                    <div>
                        <label>
                            <input type="checkbox" class="main-bg global-select">
                            <span>Select All</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <form action="{{ route('permission.store') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $role->id }}" name="role_id">
                    <table class="w-100 permission-table">
                        <!-- Dashboard Section -->
                        <tr class="border section-header">
                            <td class="border p-2" colspan="5">
                                <div class="d-flex justify-content-between">
                                    <b>1. Dashboard</b>
                                    <label>
                                        <input type="checkbox" class="main-bg section-select">
                                        <span>Select All</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr class="border">
                            <td></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('show.totalclient') ? 'checked' : '' }}
                                        value="show.totalclient" type="checkbox" class="permission"> Show total
                                    client</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('show.totalincome') ? 'checked' : '' }}
                                        value="show.totalincome" type="checkbox" class="permission"> Show total
                                    income</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('show.totalexpense') ? 'checked' : '' }}
                                        value="show.totalexpense" type="checkbox" class="permission"> Show total
                                    expense</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('show.totaldues') ? 'checked' : '' }}
                                        value="show.totaldues" type="checkbox" class="permission"> Show total
                                    dues</label></td>
                        </tr>

                        <!-- Front Office Section -->
                        <tr class="border section-header">
                            <td class="border p-2" colspan="5">
                                <div class="d-flex justify-content-between">
                                    <b>2. Front Office</b>
                                    <label>
                                        <input type="checkbox" class="main-bg section-select">
                                        <span>Select All</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr class="border">
                            <td><small>Visitor Book</small></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('visitor.create') ? 'checked' : '' }}
                                        value="visitor.create" type="checkbox" class="permission"> Create</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('visitor.read') ? 'checked' : '' }}
                                        value="visitor.read" type="checkbox" class="permission"> Read</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('visitor.edit') ? 'checked' : '' }}
                                        value="visitor.edit" type="checkbox" class="permission"> Update</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('visitor.delete') ? 'checked' : '' }}
                                        value="visitor.delete" type="checkbox" class="permission"> Delete</label></td>
                        </tr>
                        <tr class="border">
                            <td><small>Phone call log</small></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('calllog.create') ? 'checked' : '' }}
                                        value="calllog.create" type="checkbox" class="permission"> Create</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('calllog.read') ? 'checked' : '' }}
                                        value="calllog.read" type="checkbox" class="permission"> Read</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('calllog.edit') ? 'checked' : '' }}
                                        value="calllog.edit" type="checkbox" class="permission"> Update</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('calllog.delete') ? 'checked' : '' }}
                                        value="calllog.delete" type="checkbox" class="permission"> Delete</label></td>
                        </tr>
                        <tr class="border">
                            <td><small>Postal Dispatch</small></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('postal.dispatch.create') ? 'checked' : '' }}
                                        value="postal.dispatch.create" type="checkbox" class="permission">
                                    Create</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('postal.dispatch.read') ? 'checked' : '' }}
                                        value="postal.dispatch.read" type="checkbox" class="permission"> Read</label>
                            </td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('postal.dispatch.edit') ? 'checked' : '' }}
                                        value="postal.dispatch.edit" type="checkbox" class="permission"> Update</label>
                            </td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('postal.dispatch.delete') ? 'checked' : '' }}
                                        value="postal.dispatch.delete" type="checkbox" class="permission">
                                    Delete</label></td>
                        </tr>
                        <tr class="border">
                            <td><small>Postal Receive</small></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('postal.receive.create') ? 'checked' : '' }}
                                        value="postal.receive.create" type="checkbox" class="permission">
                                    Create</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('postal.receive.read') ? 'checked' : '' }}
                                        value="postal.receive.read" type="checkbox" class="permission"> Read</label>
                            </td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('postal.receive.edit') ? 'checked' : '' }}
                                        value="postal.receive.edit" type="checkbox" class="permission">
                                    Update</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('postal.receive.delete') ? 'checked' : '' }}
                                        value="postal.receive.delete" type="checkbox" class="permission">
                                    Delete</label></td>
                        </tr>
                        <tr class="border">
                            <td><small>Complain</small></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('complain.create') ? 'checked' : '' }}
                                        value="complain.create" type="checkbox" class="permission"> Create</label>
                            </td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('complain.read') ? 'checked' : '' }}
                                        value="complain.read" type="checkbox" class="permission"> Read</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('complain.edit') ? 'checked' : '' }}
                                        value="complain.edit" type="checkbox" class="permission"> Update</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('complain.delete') ? 'checked' : '' }}
                                        value="complain.delete" type="checkbox" class="permission"> Delete</label>
                            </td>
                        </tr>

                        <!-- Human Resource Section -->
                        <tr class="border section-header">
                            <td class="border p-2" colspan="5">
                                <div class="d-flex justify-content-between">
                                    <b>3. Human Resource</b>
                                    <label>
                                        <input type="checkbox" class="main-bg section-select">
                                        <span>Select All</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr class="border">
                            <td><small>Employee</small></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('employee.create') ? 'checked' : '' }}
                                        value="employee.create" type="checkbox" class="permission"> Create</label>
                            </td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('employee.read') ? 'checked' : '' }}
                                        value="employee.read" type="checkbox" class="permission"> Read</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('employee.edit') ? 'checked' : '' }}
                                        value="employee.edit" type="checkbox" class="permission"> Update</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('employee.delete') ? 'checked' : '' }}
                                        value="employee.delete" type="checkbox" class="permission"> Delete</label>
                            </td>
                        </tr>
                        <tr class="border">
                            <td><small>Role</small></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('role.create') ? 'checked' : '' }}
                                        value="role.create" type="checkbox" class="permission"> Create</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('role.read') ? 'checked' : '' }} value="role.read"
                                        type="checkbox" class="permission"> Read</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('role.edit') ? 'checked' : '' }} value="role.edit"
                                        type="checkbox" class="permission"> Update</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('role.delete') ? 'checked' : '' }}
                                        value="role.delete" type="checkbox" class="permission"> Delete</label></td>
                        </tr>
                        <tr class="border">
                            <td></td>
                            <td colspan="4"><label><input type="checkbox" {{ $role->hasPermissionTo('assign.permission') ? 'checked' : '' }} value="assign.permission" name="permissions[]" class="permission"> Assign
                                    Permission</label></td>
                        </tr>

                        <tr class="border section-header">
                            <td class="border p-2" colspan="5">
                                <div class="d-flex justify-content-between">
                                    <b>4. Settings</b>
                                    <label>
                                        <input type="checkbox" class="main-bg section-select">
                                        <span>Select All</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr class="border">
                            <td></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('organization.setting') ? 'checked' : '' }}
                                        value="organization.setting" type="checkbox" class="permission"> Organization
                                    Setting</label></td>
                            <td><label><input name="permissions[]"
                                        {{ $role->hasPermissionTo('email.setting') ? 'checked' : '' }}
                                        value="email.setting" type="checkbox" class="permission"> Email
                                    Setting</label></td>
                        </tr>

                    </table>
                    <div class="d-flex justify-content-end p-3">
                        <button type="submit" class="btn btn-success mt-2">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // GLOBAL SELECT ALL
        const globalSelect = document.querySelector('.global-select');
        if (globalSelect) {
            globalSelect.addEventListener('change', function() {
                const allCheckboxes = document.querySelectorAll(
                    'table.permission-table input[type="checkbox"]');
                allCheckboxes.forEach(cb => cb.checked = globalSelect.checked);
            });
        }

        // SECTION SELECT ALL
        document.querySelectorAll('.section-select').forEach(sectionCheckbox => {
            sectionCheckbox.addEventListener('change', function() {
                let currentRow = sectionCheckbox.closest('tr').nextElementSibling;
                while (currentRow && !currentRow.classList.contains('section-header')) {
                    currentRow.querySelectorAll('input.permission').forEach(cb => cb.checked =
                        sectionCheckbox.checked);
                    currentRow = currentRow.nextElementSibling;
                }
            });
        });

    });
</script>
@endpush
