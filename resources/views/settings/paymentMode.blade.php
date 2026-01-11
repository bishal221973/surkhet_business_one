@extends('layouts.app')

@section('page-title', 'Payment Mode')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Payment Mode</li>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="row">
            <!-- Sidebar Menu -->
            @include('settings.menu')

            <!-- Main Content -->
            <div class="col-md-9">
                {{-- {{ $fiscalYears }} --}}
                <x-table :headers="['#', 'Payment Mode', 'Description','Action']">
                    <x-slot name="addButtons">
                        <x-add-payment-mode :paymentMode="$paymentMode" />
                        {{-- <x-add-employee :employee="$employee" :roles="$roles" /> --}}
                    </x-slot>

                    @foreach ($paymentModes as $item)
                        <tr>
                            <td><small>{{ $loop->iteration }}</small></td>
                            <td><small>{{ $item->name }}</small></td>
                            <td><small>{{ $item->description }}</small></td>
                            <td>
                        <div class="d-flex gap-2">
                            <x-edit route="{{ route('paymentMode.edit', $item->id) }}" />
                            <x-delete route="{{ route('paymentMode.destroy', $item->id) }}" />


                        </div>
                    </td>
                        </tr>
                    @endforeach

                </x-table>


            </div>
        </div>
    </div>


@endsection
