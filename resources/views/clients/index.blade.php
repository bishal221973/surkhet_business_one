@extends('layouts.app')

@section('page-title', 'Client Management')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Clients</li>
@endsection

@section('content')
    <div class="container mt-1">
        <x-table :headers="['#', 'Name', 'Contact', 'Address', 'Vat Number', 'Remarks', 'Action']">
            <x-slot name="addButtons">
                {{-- <x-add-employee :employee="$employee" :roles="$roles" /> --}}
                <x-add-client :client="$client" />
            </x-slot>

            @foreach ($clients as $item)
                <tr>
                    <td><small>{{ $loop->iteration }}</small></td>
                    <td>
                        <b>{{ $item->name }}</b>
                        <small class="d-block">{{ $item->type }}</small>
                    </td>
                    <td>
                        <small class="d-block">{{ $item->email }}</small>
                        <small class="d-block">{{ $item->phone }}</small>
                    </td>
                    <td>{{ $item->address }}</td>
                    <td>{{ $item->vat_number }}</td>
                    <td>{{ $item->remarks }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <x-edit route="{{ route('client.edit', $item->id) }}" />
                            <x-delete route="{{ route('client.destroy', $item->id) }}" />


                        </div>
                    </td>
                </tr>
            @endforeach

        </x-table>
    </div>


@endsection
