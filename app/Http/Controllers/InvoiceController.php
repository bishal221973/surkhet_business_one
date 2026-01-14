<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoice.index', [
            'invoices' => \App\Models\Invoice::with('client','services.service')->latest()->get(),
            'invoice' => new \App\Models\Invoice(),
        ]);
    }


    public function create()
    {
        $estimated_invoice=1;
        $invoice=Invoice::latest()->first();

        if($invoice){
            $estimated_invoice=$invoice->estimated_invoice+1;
        }
        return view('invoice.create', [
            'invoices' => \App\Models\Invoice::with('client')->latest()->get(),
            'invoice' => new \App\Models\Invoice(),
            'clients' => \App\Models\Client::where('organization_id', organization()->id)->get(),
            'services' => \App\Models\Service::where('organization_id', organization()->id)->get(),
            'units' => \App\Models\Unit::where('organization_id',organization()->id)->get(),
            'estimated_invoice'=>$estimated_invoice
        ]);
    }

    public function store(Request $request)
    {
        // return organization()->id;
        $validated = $request->validate(\App\Models\Invoice::rules());

        $invoice=\App\Models\Invoice::create($validated);
        if($request->services){
            foreach($request->services as $service){
                InvoiceService::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => $service['service_id'],
                    'unit_id' => $service['unit_id'],
                    'quantity' => $service['quantity'],
                    'rate' => $service['rate'],
                    'amount' => $service['amount'],
                ]);
            }
        }
        createTimeline(
            'New Invoice Created',
            'New invoice ' . $request->invoice_number . ' has been created by ' . auth()->user()->name,
            'cash'
        );
        return redirect()->back()->with('success', 'Invoice created successfully.');
    }


    public function edit($id)
    {
        $invoice = \App\Models\Invoice::with('services.service','client')->findOrFail($id);
        return view('invoice.create', [
            'invoices' => Invoice::all(),
            'invoice' => $invoice,
            'clients' => \App\Models\Client::where('organization_id', organization()->id)->get(),
            'services' => \App\Models\Service::where('organization_id', organization()->id)->get(),
            'units' => \App\Models\Unit::where('organization_id', organization()->id)->get(),
            'estimated_invoice' => $invoice->estimated_invoice
        ]);
    }

    public function update(Request $request, $id)
    {
        $invoice = \App\Models\Invoice::findOrFail($id);

        $validated = $request->validate(\App\Models\Invoice::rules());

        $invoice->update($validated);

        if($request->services){
            InvoiceService::where('invoice_id', $invoice->id)->delete();
            foreach($request->services as $service){
                if(!$service['service_id']){
                    continue;
                }
                InvoiceService::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => $service['service_id'],
                    'unit_id' => $service['unit_id'],
                    'quantity' => $service['quantity'],
                    'rate' => $service['rate'],
                    'amount' => $service['amount'],
                ]);
            }
        }
        createTimeline(
            'Selected Invoice Updated',
            'Selected invoice ' . $invoice->invoice_number . ' has been updated by ' . auth()->user()->name,
            'cash'
        );
        return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        $invoice = \App\Models\Invoice::findOrFail($id);
        $invoice->delete();

        createTimeline(
            'Selected Invoice Removed',
            'Selected invoice ' . $invoice->invoice_number . ' has been removed by ' . auth()->user()->name,
            'cash'
        );

        return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully.');
    }
}
