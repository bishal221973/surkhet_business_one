{{--
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Reference</th>
            <th>Debit (Rs.)</th>
            <th>Credit (Rs.)</th>
            <th>Balance (Rs.)</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($ledger as $row)
            <tr>
                <td>{{ $row['date']->format('Y-m-d') }}</td>
                <td>{{ $row['type'] }}</td>
                <td>{{ $row['ref'] }}</td>
                <td>{{ $row['debit'] ?: '-' }}</td>
                <td>{{ $row['credit'] ?: '-' }}</td>
                <td>{{ $row['balance'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table> --}}

<x-table :headers="['#', 'Date', 'Invoice No.', 'Particulars', 'Debit', 'Credit','Balance']">
     <x-slot name="addButtons">
     </x-slot>

      @foreach ($ledger as $row)
            <tr>
                <td><small>{{ $loop->iteration }}</small></td>
                <td><small>{{ $row['date']->format('Y-m-d') }}</small></td>
                <td><small>{{ $row['ref'] }}</small></td>
                <td><small>{{ $row['type'] }}</small></td>
                <td><small>{{ $row['debit'] ?: '-' }}</small></td>
                <td><small>{{ $row['credit'] ?: '-' }}</small></td>
                <td><small>{{ $row['balance'] }}</small></td>
            </tr>
        @endforeach
     {{-- <x-slot name="footer">
         <tr>
             <td>Total</td>
             <td></td>
             <td>Rs. {{ $client->invoices()->sum('total') }}</td>
             <td>Rs. {{ $client->invoices()->sum('total') - $client->invoices()->sum('payable_amount') }}</td>
             <td>Rs. {{ $client->invoices()->sum('payable_amount') }}</td>
         </tr>
     </x-slot> --}}
 </x-table>
