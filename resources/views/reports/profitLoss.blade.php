@extends('layouts.app')

@section('page-title', 'Profit & Loss (Dr/Cr)')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Reports</li>
    <li class="breadcrumb-item active" aria-current="page">Profit & Loss</li>
@endsection
@section('content')
<div class="container">
    {{-- <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($from)->format('d M, Y') }}
        to {{ \Carbon\Carbon::parse($to)->format('Y-m-d') }}</p> --}}

        <form action="{{ route('pl.report') }}" method="GET" id="plFilterForm">
    <div class="d-flex gap-3 align-items-end">
        <div class="form-group">
            <label for="month">Select Month</label>
            <select
                name="month"
                id="month"
                class="form-control"
                onchange="this.form.submit()"
            >
                @php
                    $selectedMonth = request('month') ?? now()->format('Y-m');
                @endphp

                @for ($m = 1; $m <= 12; $m++)
                    @php
                        $value = now()->year . '-' . str_pad($m, 2, '0', STR_PAD_LEFT);
                        $label = \Carbon\Carbon::create()->month($m)->format('F');
                    @endphp
                    <option value="{{ $value }}" {{ $selectedMonth == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endfor
            </select>
        </div>
    </div>
</form>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="4" class="text-center">Debit (Dr)</th>
                <th colspan="4" class="text-center">Credit (Cr)</th>
            </tr>
            <tr>
                <th>S.N.</th>
                <th>Date</th>
                <th>Particular</th>
                <th class="text-end">Amount</th>
                <th>S.N.</th>
                <th>Date</th>
                <th>Particular</th>
                <th class="text-end">Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $max = max(count($dr), count($cr));
            @endphp
            @for ($i = 0; $i < $max; $i++)
            <tr>
                <!-- Dr Side -->
                <td>{{ $i+1 }}</td>
                <td>{{ $dr[$i]->payment_date ?? '' }}</td>
                <td>{{ $dr[$i]->description ?? '' }}</td>
                <td class="text-end">{{ isset($dr[$i]) ? number_format($dr[$i]->amount,2) : '' }}</td>

                <!-- Cr Side -->
                <td>{{ $i+1 }}</td>
                <td>{{ $cr[$i]->payment_date ?? '' }}</td>
                <td>{{ $cr[$i]->description ?? '' }}</td>
                <td class="text-end">{{ isset($cr[$i]) ? number_format($cr[$i]->amount,2) : '' }}</td>
            </tr>
            @endfor
            <!-- Totals -->
            <tr>
                <td colspan="3"><strong>Total Dr</strong></td>
                <td class="text-end"><strong>{{ number_format($totalDr,2) }}</strong></td>
                <td colspan="3"><strong>Total Cr</strong></td>
                <td class="text-end"><strong>{{ number_format($totalCr,2) }}</strong></td>
            </tr>
            <!-- Net Profit / Loss -->
            @if($totalCr > $totalDr)
            <tr>
                <td colspan="3"><strong>Net Profit</strong></td>
                <td class="text-end"><strong>{{ number_format($totalCr - $totalDr,2) }}</strong></td>
                <td colspan="4"></td>
            </tr>
            @elseif($totalDr > $totalCr)
            <tr>
                <td colspan="4"></td>
                <td colspan="3"><strong>Net Loss</strong></td>
                <td class="text-end"><strong>{{ number_format($totalDr - $totalCr,2) }}</strong></td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
