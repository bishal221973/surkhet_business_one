@extends('layouts.app')

@section('page-title', 'Income')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Income</li>
@endsection

@section('content')
    <div class="container mt-1">
        <x-table :headers="[
            '#',
            'Title',
            'Bank',
            'Payment Mode',
            'Client',
            'Date',
            'Amount',
            'Remarks',
            'Action',
        ]">
            <x-slot name="addButtons">
                <x-add-income :income="$income"/>
            </x-slot>

            @foreach ($incomes as $item)
                <tr>
                    <td><small>{{ $loop->iteration }}</small></td>
                    <td><small>{{ $item->title }}</small></td>
                    <td><small>{{ $item->bank->name }}</small></td>
                    <td><small>{{ $item->paymentMode->name }}</small></td>
                    <td><small>{{ $item?->client?->name ?? "-" }}</small></td>
                    <td><small>{{ $item->payment_date }}</small></td>
                    <td><small>Rs. {{ $item->amount }}</small></td>
                    <td><small>{{ $item->description }}</small></td>

                    <td>
                        <div class="d-flex gap-2">
                            <x-edit route="{{ route('income.edit', $item->id) }}" />
                            <x-delete route="{{ route('income.destroy', $item->id) }}" />


                        </div>
                    </td>
                </tr>
            @endforeach

            <x-slot name="footer">
                <tr>
                    <td></td>
                    <td style="font-size: 13px">Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-size: 13px">Rs. {{ $incomes->sum('amount') }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </x-slot>

        </x-table>
    </div>


@endsection
