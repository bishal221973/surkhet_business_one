@extends('layouts.app')

@section('page-title', 'Unit')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Unit</li>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="row">
            <!-- Sidebar Menu -->
            @include('settings.menu')

            <!-- Main Content -->
            <div class="col-md-9">
                {{-- {{ $fiscalYears }} --}}
                <x-table :headers="['#', 'Unit', 'Description','Action']">
                    <x-slot name="addButtons">
                        <x-add-unit :unit="$unit" />
                        {{-- <x-add-employee :employee="$employee" :roles="$roles" /> --}}
                    </x-slot>

                    @foreach ($units as $item)
                        <tr>
                            <td><small>{{ $loop->iteration }}</small></td>
                            <td><small>{{ $item->name }}</small></td>
                            <td><small>{{ $item->description }}</small></td>
                            <td>
                        <div class="d-flex gap-2">
                            <x-edit route="{{ route('unit.edit', $item->id) }}" />
                            <x-delete route="{{ route('unit.destroy', $item->id) }}" />


                        </div>
                    </td>
                        </tr>
                    @endforeach

                </x-table>


            </div>
        </div>
    </div>


@endsection
