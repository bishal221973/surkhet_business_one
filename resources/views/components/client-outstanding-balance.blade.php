 <x-table :headers="['#', 'Invoice No.', 'Payable Amount', 'Paid Amount', 'Outstanding Amount']">
     <x-slot name="addButtons">
     </x-slot>

     @php
         $index=1
     @endphp
     @foreach ($client->invoices as $item)
         @if ($item?->payable_amount <= 0)
             @continue;
         @endif
         <tr>
             <td><small>{{ $index++ }}</small></td>
             <td>
                 <small class="d-block">{{ $item->invoice_number }}</small>
             </td>
             <td>
                 <small class="d-block">Rs. {{ $item?->total }}</small>
             </td>
             <td>
                 <small class="d-block">Rs. {{ $item->total - $item?->payable_amount }}</small>
             </td>
             <td>
                 <small class="d-block">Rs. {{ $item?->payable_amount }}</small>
             </td>


         </tr>
     @endforeach
     <x-slot name="footer">
         <tr>
             <td>Total</td>
             <td></td>
             <td>Rs. {{ $client->invoices()->sum('total') }}</td>
             <td>Rs. {{ $client->invoices()->sum('total') - $client->invoices()->sum('payable_amount') }}</td>
             <td>Rs. {{ $client->invoices()->sum('payable_amount') }}</td>
         </tr>
     </x-slot>
 </x-table>
