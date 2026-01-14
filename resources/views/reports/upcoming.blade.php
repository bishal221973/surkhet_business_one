@extends('layouts.app')

@section('page-title', 'Upcoming Dues')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Reports</li>
    <li class="breadcrumb-item active" aria-current="page">Upcoming Dues</li>
@endsection

@section('content')
    <div class="container mt-1">
        <x-table :headers="[
            '#',
            'Est. Invoice',
            'Client',
            'Due Date',
            'Sub Total',
            'Discount',
            'Net Amount',
            'Vat Amount',
            'Total Amount',
            'Paid Amount',
            'Payable Amount',
            'Status',
        ]">
            <x-slot name="addButtons">

            </x-slot>

            @foreach ($invoices as $item)
                <tr>
                    <td><small>{{ $loop->iteration }}</small></td>
                    <td>
                        <x-invoice-show :invoice="$item" />

                        {{-- <small class="d-block">{{ $item->invoice_number }}</small> --}}
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
                        <small class="d-block">Rs. {{ $item?->total - $item?->payable_amount }}</small>
                    </td>
                    <td>
                        <small class="d-block">Rs. {{ $item?->payable_amount }}</small>
                    </td>
                    <td>
                        <small class="d-block">{{ invoiceStatus($item) }}</small>
                    </td>
                </tr>
            @endforeach


            <x-slot name="footer">
                <tr>
                    <td></td>
                    <td style="font-size: 13px">Total</td>
                    <td></td>
                    <td></td>
                    <td style="font-size: 13px">Rs. {{ $invoices->sum('sub_total') }} </td>
                    <td style="font-size: 13px">Rs. {{ $invoices->sum('discount') }} </td>
                    <td style="font-size: 13px">Rs. {{ $invoices->sum('net_amount') }} </td>
                    <td style="font-size: 13px">Rs. {{ $invoices->sum('vat_amount') }} </td>
                    <td style="font-size: 13px">Rs. {{ $invoices->sum('total') }} </td>
                    <td style="font-size: 13px">Rs. {{ $invoices->sum('total') - $invoices->sum('payable_amount') }} </td>
                    <td style="font-size: 13px">Rs. {{ $invoices->sum('payable_amount') }} </td>
                    <td></td>
                </tr>
            </x-slot>

        </x-table>
    </div>


@endsection
