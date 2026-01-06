@extends('layouts.app')

@section('page-title', 'Email Setting')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Email Setting</li>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="row">
            <!-- Sidebar Menu -->
            @include('settings.menu')

            <!-- Main Content -->
            <div class="col-md-9">
                {{-- {{ $fiscalYears }} --}}
                <x-table :headers="['#', 'Name', 'Start Date', 'End Date', 'Status', 'Action']">
                    <x-slot name="addButtons">
                        <x-add-fiscalyear :fiscalYear="$fiscalYear" />
                        {{-- <x-add-employee :employee="$employee" :roles="$roles" /> --}}
                    </x-slot>

                    @foreach ($fiscalYears as $fiscalYear)
                        <tr>
                            <td><small>{{ $loop->iteration }}</small></td>
                            <td><small>{{ $fiscalYear->name }}</small></td>
                            <td><small>{{ $fiscalYear->start_date }}</small></td>
                            <td><small>{{ $fiscalYear->end_date }}</small></td>
                            <td><small>{{ $fiscalYear->is_active ? 'Active' : 'Inactive' }}</small></td>
                            <td>
                        <div class="d-flex gap-2">
                            <x-edit route="{{ route('fiscalyear.edit', $fiscalYear->id) }}" />
                            <x-delete route="{{ route('fiscalyear.destroy', $fiscalYear->id) }}" />


                        </div>
                    </td>
                        </tr>
                    @endforeach

                </x-table>


            </div>
        </div>
    </div>


@endsection
