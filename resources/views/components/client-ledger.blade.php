<x-table :headers="['#', 'Date', 'Invoice No.', 'Particulars', 'Debit', 'Credit', 'Balance']">
    <x-slot name="addButtons">
    </x-slot>

    @foreach ($ledger as $row)
        <tr>
            <td><small>{{ $loop->iteration }}</small></td>
            <td><small>{{ $row['date'] ? $row['date']->format('Y-m-d') : '-' }}</small></td>
            <td><small>{{ $row['ref'] }}</small></td>
            <td><small>{{ $row['type'] }}</small></td>
            <td><small>{{ $row['debit'] ?: '-' }}</small></td>
            <td><small>{{ $row['credit'] ?: '-' }}</small></td>
            <td><small>{{ $row['balance'] }}</small></td>
        </tr>
    @endforeach
    @php
        $totalDebit = $ledger->sum('debit');
        $totalCredit = $ledger->sum('credit');
        $closingBalance = $ledger->last()['balance'] ?? 0;
    @endphp

    <x-slot name="footer">
    <tr class="fw-bold">
        <td class="text-end">Total</td>
        <td class="text-end"></td>
        <td class="text-end"></td>
        <td class="text-end"></td>
        <td>Rs. {{ $totalDebit }}</td>
        <td>Rs. {{ $totalCredit }}</td>
        <td>Rs. {{ $closingBalance }}</td>
    </tr>
</x-slot>

</x-table>
