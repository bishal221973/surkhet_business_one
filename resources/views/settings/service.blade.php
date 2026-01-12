@extends('layouts.app')

@section('page-title', 'Unit')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Unit</li>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="row">
            @include('settings.menu')

            <div class="col-md-9">
                <x-table :headers="['#', 'Name', 'Type','Rate','Unit','Description', 'Action']">
                    <x-slot name="addButtons">
                        <x-add-service :service="$service" />
                    </x-slot>

                    @foreach ($services as $item)
                        <tr>
                            <td><small>{{ $loop->iteration }}</small></td>
                            <td><small>{{ $item->name }}</small></td>
                            <td><small>{{ $item->type }}</small></td>
                            <td><small>Rs. {{ $item->rate }}</small></td>
                            <td><small>{{ $item->unit?->name }}</small></td>
                            <td><small>{{ $item->description }}</small></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <x-edit route="{{ route('service.edit', $item->id) }}" />
                                    <x-delete route="{{ route('service.destroy', $item->id) }}" />


                                </div>
                            </td>
                        </tr>
                    @endforeach

                </x-table>


            </div>
        </div>
    </div>


@endsection
