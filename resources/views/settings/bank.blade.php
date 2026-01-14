@extends('layouts.app')

@section('page-title', 'Bank Account')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Bank Account</li>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="row">
            @include('settings.menu')

            <div class="col-md-9">
                <x-table :headers="['#', 'Name', 'Balance', 'Remarks', 'Action']">
                    <x-slot name="addButtons">
                        <x-add-bank :bank="$bank" />
                    </x-slot>

                    @foreach ($banks as $item)
                        <tr>
                            <td><small>{{ $loop->iteration }}</small></td>
                            <td><small>{{ $item->name }}</small></td>
                            <td><small>Rs. {{ $item->balance }}</small></td>
                            <td><small>{{ $item->description }}</small></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <x-edit route="{{ route('bank.edit', $item->id) }}" />
                                    <x-delete route="{{ route('bank.destroy', $item->id) }}" />


                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <x-slot name="footer">
                        <tr>
                            <td></td>
                            <td style="font-size: 12px">Total</td>
                            <td style="font-size: 12px">Rs. {{ $banks->sum('balance') }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </x-slot>

                </x-table>


            </div>
        </div>
    </div>


@endsection
