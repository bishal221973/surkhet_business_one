@extends('layouts.app')

@section('page-title', 'Payments')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Payments</li>
@endsection

@section('content')
    <div class="container mt-1">
        <x-table :headers="['#', 'Invoice Number', 'Payment Mode', 'Bank', 'Date','Amount','Receiver', 'Remarks']">
            <x-slot name="addButtons">
                <x-add-payment />
            </x-slot>

            @foreach ($payments as $item)
                <tr>
                    <td><small>{{ $loop->iteration }}</small></td>
                    <td>
                        <b>{{ $item->invoice->invoice_number }}</b>
                        <small class="d-block">{{ $item->invoice->client->name }}</small>
                    </td>
                    <td>
                        <small class="d-block">{{ $item->paymentMode->name }}</small>

                    </td>
                    <td>{{ $item->bank->name }}</td>
                    <td>{{ $item->payment_date }}</td>
                    <td>Rs. {{ $item->amount }}</td>
                    <td>{{ $item->receiver->name }}</td>
                    <td>{{ $item->description }}</td>

                </tr>
            @endforeach

        </x-table>
    </div>


@endsection
