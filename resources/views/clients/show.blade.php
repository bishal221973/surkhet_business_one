@extends('layouts.app')

@section('page-title', 'Client Management')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Clients</li>
    <li class="breadcrumb-item active" aria-current="page">Show</li>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="card" style="background-color: var(--primary)">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center gap-3" style="padding-right:30px;border-right: 1px solid #ccc">
                        <img src="{{ asset('images/user.png') }}" style="height:50px" alt="">
                        <div class="d-block">
                            <h5 class="text-white">{{ $client->name }}</h5>
                            <small class="text-white">Type: {{ $client->type }}</small>
                        </div>
                    </div>

                    <div class="block text-white" style="padding-left:30px;padding-right:30px;border-right: 1px solid #ccc">
                        <small class="d-block">
                            <i class="fa fa-phone"></i> {{ $client->phone }}
                        </small>
                        <small class="d-block"><i class="fa fa-phone"></i> {{ $client->email }}</small>
                        <small class="d-block"><i class="fa fa-location-dot"></i> {{ $client->address }}</small>
                    </div>
                    <div class="block text-white" style="padding-left:30px;padding-right:30px;">
                        <small class="d-block">
                            <b>VAT No.:</b> {{ $client?->vat_number }}
                        </small>
                        <small class="d-block">
                            <b>Remarks:</b> {{ $client?->remarks }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-1 mt-3">
            <a href="{{ route('client.show', $client->id) }}?type=invoices"
                class="btn {{ request()->type == 'invoices' ? 'active-btn' : 'btn-secondary' }}">Invoices</a>
            <a href="{{ route('client.show', $client->id) }}?type=payment"
                class="btn {{ request()->type == 'payment' ? 'active-btn' : 'btn-secondary' }}">Payments</a>
            <a href="{{ route('client.show', $client->id) }}?type=os_balance"
                class="btn {{ request()->type == 'os_balance' ? 'active-btn' : 'btn-secondary' }}">Outstanding Balance</a>
        </div>
        @if (request()->type == 'invoices')
            <x-client-invoices :client="$client" />
        @elseif(request()->type == 'payment')
        <x-client-payments :client="$client" />
        @else
        <x-client-outstanding-balance :client="$client" />
        @endif
    </div>


@endsection
