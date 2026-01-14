@extends('layouts.app')

@section('page-title', 'Expense')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Expense</li>
@endsection

@section('content')
    <div class="container mt-1">
        <x-table :headers="[
            '#',
            'Expense Head',
            'Title',
            'Payment Mode',
            'Bank',
            'Date',
            'Amount',
            'Expense By',
            'Remarks',
            'Action',
        ]">
            <x-slot name="addButtons">
                <x-add-expense :expense="$expense"/>
            </x-slot>

            @foreach ($expenses as $item)
                <tr>
                    <td><small>{{ $loop->iteration }}</small></td>
                    <td><small>{{ $item->expenseHead->name }}</small></td>
                    <td><small>{{ $item->title }}</small></td>
                    <td><small>{{ $item->paymentMode->name }}</small></td>
                    <td><small>{{ $item->bank->name }}</small></td>
                    <td><small>{{ $item->payment_date }}</small></td>
                    <td><small>Rs. {{ $item->amount }}</small></td>
                    <td><small>{{ $item->expenseBy->name }}</small></td>
                    <td><small>{{ $item->description }}</small></td>
                    <td>
                        <div class="d-flex gap-2">
                            <x-edit route="{{ route('expense.edit', $item->id) }}" />
                            <x-delete route="{{ route('expense.destroy', $item->id) }}" />


                        </div>
                    </td>
                </tr>
            @endforeach

            <x-slot name="footer">
                <tr>
                    <td style="font-size: 13px">Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-size: 13px">Rs. {{ $expenses->sum('amount') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </x-slot>

        </x-table>
    </div>


@endsection
