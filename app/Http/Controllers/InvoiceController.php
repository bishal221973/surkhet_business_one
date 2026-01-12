<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoice.index', [
            'invoices' => \App\Models\Invoice::with('client')->latest()->get(),
            'invoice' => new \App\Models\Invoice(),
        ]);
    }


    public function create()
    {
        return view('invoice.create', [
            'invoices' => \App\Models\Invoice::with('client')->latest()->get(),
            'invoice' => new \App\Models\Invoice(),
            'clients' => \App\Models\Client::where('organization_id', organization()->id)->get(),
            'services' => \App\Models\Service::where('organization_id', organization()->id)->get(),
            'units' => \App\Models\Unit::where('organization_id',organization()->id)->get(),
        ]);
    }

    public function store(Request $request)
    {
        // return $request;
        $validated = $request->validate(\App\Models\Invoice::rules());

        \App\Models\Invoice::create($validated);
        createTimeline(
            'New Invoice Created',
            'New invoice ' . $request->invoice_number . ' has been created by ' . auth()->user()->name,
            'cash'
        );
        return redirect()->back()->with('success', 'Invoice created successfully.');
    }


    public function edit($id)
    {
        $invoice = \App\Models\Invoice::findOrFail($id);

        return view('invoice.index', [
            'invoices' => \App\Models\Invoice::all(),
            'invoice' => $invoice,
        ]);
    }

    public function update(Request $request, $id)
    {
        $invoice = \App\Models\Invoice::findOrFail($id);

        $validated = $request->validate(\App\Models\Invoice::rules());

        $invoice->update($validated);
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
