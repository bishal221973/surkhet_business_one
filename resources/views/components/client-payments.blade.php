 <x-table :headers="['#', 'Invoice No.', 'Payment Mode', 'Bank', 'Date', 'Amount', 'Receiver', 'Remarks']">
     <x-slot name="addButtons">
     </x-slot>
     @php
         $totalAmt = 0;
     @endphp

     @foreach ($client->invoices as $item)
         @foreach ($item->payments as $payment)
             <tr>
                 <td><small>{{ $loop->iteration }}</small></td>
                 <td>
                     <small class="d-block">{{ $item->invoice_number }}</small>
                 </td>
                 <td>
                     <small class="d-block">{{ $payment?->paymentMode?->name }}</small>
                 </td>
                 <td>
                     <small class="d-block">{{ $payment?->bank?->name }}</small>
                 </td>
                 <td>
                     <small class="d-block">{{ $payment?->payment_date }}</small>
                 </td>
                 <td>
                     <small class="d-block">Rs. {{ $payment?->amount }}</small>
                 </td>
                 <td>
                     <small class="d-block">{{ $payment?->receiver?->name }}</small>
                 </td>
                 <td>
                     <small class="d-block">{{ $payment?->description }}</small>
                 </td>
             </tr>

             @php
                 $totalAmt += $payment?->amount;
             @endphp
         @endforeach
     @endforeach

     <x-slot name="footer">
         <tr>
             <td></td>
             <td style="font-size: 13px">Total</td>
             <td></td>
             <td></td>
             <td></td>
             <td style="font-size: 13px">Rs. {{ $totalAmt }} </td>
             <td style="font-size: 13px"> </td>
             <td style="font-size: 13px"> </td>
             <td></td>
         </tr>
     </x-slot>
 </x-table>
