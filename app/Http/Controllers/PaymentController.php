<?php

namespace App\Http\Controllers;

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
        createTimeline(
            'New Payment Created',
            'New payment of invoice number  ' . $invoice->invoice_number . ' has been created by ' . auth()->user()->name,
            'user'
        );
        return redirect()->route('payment.index')->with('success', 'Payment created successfully.');
    }
}
