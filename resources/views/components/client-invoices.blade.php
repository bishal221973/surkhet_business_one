 <x-table :headers="[
     '#',
     'Est. Invoice',
     'Due Date',
     'Sub Total',
     'Discount',
     'Net Amount',
     'VAT Amount',
     'Total Amount',
     'Status',
     'Remarks',
 ]">
     <x-slot name="addButtons">
         <x-add-invoice :client="$client" />
     </x-slot>


     @foreach ($client->invoices as $item)
         <tr>
             <td><small>{{ $loop->iteration }}</small></td>
             <td>
                 <x-invoice-show :invoice="$item" />
                 {{-- <small class="d-block">{{ $item->invoice_number }}</small> --}}
             </td>

             <td>
                 <small class="d-block">{{ $item?->due_date }}</small>
             </td>
             <td>
                 <small class="d-block">Rs. {{ $item?->sub_total }}</small>
             </td>
             <td>
                 <small class="d-block">Rs. {{ $item?->discount }}</small>
             </td>
             <td>
                 <small class="d-block">Rs. {{ $item?->net_amount }}</small>
             </td>
             <td>
                 <small class="d-block">Rs. {{ $item?->vat_amount }}</small>
             </td>
             <td>
                 <small class="d-block">Rs. {{ $item?->total }}</small>
             </td>
             <td>
                 <small class="d-block">{{ invoiceStatus($item) }}</small>
             </td>
             <td>
                 <small class="d-block">{{ $item?->remarks }}</small>
             </td>


         </tr>
     @endforeach

     <x-slot name="footer">
         <tr>
             <td></td>
             <td style="font-size: 13px">Total</td>
             <td></td>
             <td style="font-size: 13px">Rs. {{ $client->invoices->sum('sub_total') }} </td>
             <td style="font-size: 13px">Rs. {{ $client->invoices->sum('discount') }} </td>
             <td style="font-size: 13px">Rs. {{ $client->invoices->sum('net_amount') }} </td>
             <td style="font-size: 13px">Rs. {{ $client->invoices->sum('vat_amount') }} </td>
             <td style="font-size: 13px">Rs. {{ $client->invoices->sum('total') }} </td>
             <td style="font-size: 13px"> </td>
             <td style="font-size: 13px"> </td>
             <td></td>
         </tr>
     </x-slot>

 </x-table>
