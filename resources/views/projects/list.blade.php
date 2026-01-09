@extends('layouts.app')

@section('page-title', 'Projects')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Projects</li>
@endsection

@section('content')
    <div class="container mt-1">
        <x-table :headers="['#', 'Client', 'Project Name', 'Start Date', 'Status', 'Total Tasks', 'Assigned Staffs', 'Action']">
            <x-slot name="addButtons">
                {{-- <x-add-employee :employee="$employee" :roles="$roles" /> --}}
                {{-- <x-add-client :client="$client" /> --}}
                <a href="{{ route('project.create') }}" class="main-bg border-0 px-3 rounded shadow btn text-white">
                    <i class="fa fa-plus"></i>
                    Add Project
                </a>
            </x-slot>

            @foreach ($projects as $item)
                <tr>
                    <td><small>{{ $loop->iteration }}</small></td>
                    <td>
                        <small>{{ $item?->client?->name }}</small>
                        <small class="d-block text-secondary">{{ $item?->client?->email }}</small>
                    </td>
                    <td><small>{{ $item?->project_name }}</small></td>
                    <td><small>{{ $item?->start_date }}</small></td>
                    <td><small>{{ $item?->status }}</small></td>
                    <td><small>{{ $item?->tasks?->count() }} Tasks</small></td>
                    <td>
                        @php
                            // Collect all assigned user IDs for this project/item
                            $allUserIds = collect();
                            foreach ($item?->tasks as $task) {
                                $allUserIds = $allUserIds->merge($task->assigned_to ?? []);
                            }

                            // Remove duplicates
                            $uniqueUserIds = $allUserIds->unique();

                            // Fetch user models once
                            $users = \App\Models\User::whereIn('id', $uniqueUserIds)->get();
                        @endphp
                        <div class="assigned-users d-flex flex-wrap gap-1">
                            @foreach ($users as $user)
                                <div class="user-avatar" title="{{ $user->name }}">
                                    <img src="{{ asset('images/user.png') }}" class="rounded-circle"
                                        style="height: 30px; width:30px; object-fit:cover;" alt="{{ $user->name }}">
                                </div>
                            @endforeach
                        </div>
                    </td>

                    <td>
                        <div class="d-flex gap-2">
                            <x-edit route="{{ route('project.edit', $item->id) }}" />
                            <x-delete route="{{ route('client.destroy', $item->id) }}" />


                        </div>
                    </td>
                </tr>
            @endforeach

        </x-table>
    </div>
@endsection
