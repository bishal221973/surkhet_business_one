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

    public function store(Request $request)
    {
        // return $request;
        $validated = $request->validate(\App\Models\Invoice::rules());

        \App\Models\Invoice::create($validated);

        return redirect()->route('invoice.index')->with('success', 'Invoice created successfully.');
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

        return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        $invoice = \App\Models\Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully.');
    }
}
