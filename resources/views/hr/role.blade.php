@extends('layouts.app')

@section('content')
@section('page-title', 'Role')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Human Resource</li>
    <li class="breadcrumb-item active" aria-current="page">Role</li>
@endsection
<div class="app-content">
    <div class="container-fluid">
        <x-table :headers="['#', 'Name', 'Permission','Action']" >
           <x-slot name="addButtons">
            <x-add-role :role="$role"/>
           </x-slot>
            {{-- @for ($i = 1; $i <= 50; $i++)
                <tr class="{{ $i % 2 === 0 ? 'gray-td' : '' }}">
                    <td class="px-4 py-2">{{ $i }}</td>
                    <td class="px-4 py-2">User {{ $i }}</td>
                    <td class="px-4 py-2">user{{ $i }}@example.com</td>
                    <td class="px-4 py-2">
                        <button class="text-blue-600">Edit</button>
                    </td>
                </tr>
            @endfor --}}

            @foreach ($roles as $role)
                <tr class="{{ $loop->iteration % 2 === 0 ? 'gray-td' : '' }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->permissions->count() }} Permissions</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('permission.index', $role->id) }}" class="btn btn-info btn-sm"><i class="fa fa-key"></i></a>
                            <a href="{{ route('role.edit', $role->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('role.destroy', $role->id) }}" onsubmit=" return confirm('Are you sure?')" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach

        </x-table>


    </div>
</div>
@endsection
