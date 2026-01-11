@extends('layouts.app')

@section('page-title', 'Invoice Management')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Invoice Management</li>
@endsection

@section('content')
    <div class="container mt-1">
        <x-table :headers="['#', 'Invoice Number', 'Client', 'Due Date', 'Sub Total','Discount','Net Amount', 'Vat Amount','Total Amount','Status', 'Action']">
            <x-slot name="addButtons">
                {{-- <x-add-employee :employee="$employee" :roles="$roles" /> --}}
                <x-add-invoice :invoice="$invoice" />
            </x-slot>

            @foreach ($invoices as $item)
                <tr>
                    <td><small>{{ $loop->iteration }}</small></td>
                    <td>
                        <small class="d-block">{{ $item->invoice_number }}</small>
                    </td>
                    <td>
                        <small class="d-block">
                            {{ $item?->client?->name }}
                        </small>
                        <small class="d-block">
                            {{ $item?->client?->phone }}
                        </small>
                    </td>
                    <td>
                        <small class="d-block">{{ $item?->due_date }}</small>
                    </td>
                    <td>
                        <small class="d-block">Rs. {{ $item?->sub_total }}</small>
                    </td>
                    <td>
                        <small class="d-block">Rs. {{ $item?->discount }}</small>
                    </td>
                    <td>
                        <small class="d-block">Rs. {{ $item?->net_amount }}</small>
                    </td>
                    <td>
                        <small class="d-block">Rs. {{ $item?->vat_amount }}</small>
                    </td>
                    <td>
                        <small class="d-block">Rs. {{ $item?->total }}</small>
                    </td>
                     <td>
                        <small class="d-block">{{ $item?->status }}</small>
                    </td>

                    <td>
                        <div class="d-flex gap-2">
                            <x-edit route="{{ route('invoice.edit', $item->id) }}" />
                            <x-delete route="{{ route('invoice.destroy', $item->id) }}" />


                        </div>
                    </td>
                </tr>
            @endforeach

        </x-table>
    </div>


@endsection
