<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){
       $payments=Payment::with(['invoice.client','paymentMode','bank','receiver'])->where('organization_id', organization()->id)->get();
        return view('payments.index',[
            'payments'=>$payments
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(Payment::rules());
        $invoice=Invoice::find($data['invoice_id']);
        Payment::create($data);
        $client = Client::find(id: $invoice->client_id);

        if ($client->email) {
            $data = [
                'invoice_number' => $invoice->estimated_invoice,
                'invoice_date' => $invoice->created_at->format('Y-m-d'),
                'payment_date' => $data['payment_date'],
                'amount' => $data['amount'],
                'name' => $client->name
            ];
            notifyMail($client->email, 'payment_received_mail', $data);
        }
        createTimeline(
            'New Payment Created',
            'New payment of invoice number  ' . $invoice->invoice_number . ' has been created by ' . auth()->user()->name,
            'user'
        );
        return redirect()->route('payment.index')->with('success', 'Payment created successfully.');
    }
}
