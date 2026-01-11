<?php

namespace App\Http\Controllers;

use App\Models\PaymentMode;
use Illuminate\Http\Request;

class PaymentModeController extends Controller
{
    public function index()
    {
        return view('settings.paymentMode', [
            'paymentMode' => new PaymentMode(),
            'paymentModes' => PaymentMode::where('organization_id', organization()->id)->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(PaymentMode::rules());
        if (!empty($validated['is_active']) && $validated['is_active']) {
            // Deactivate all other fiscal years
            PaymentMode::where('is_active', true)->update(['is_active' => false]);
        }
        PaymentMode::create($validated);

        return redirect()->route('paymentMode.index')->with('success', 'Payment mode created successfully.');
    }

    public function edit($id)
    {
        return view('settings.paymentMode', [
            'paymentMode' => PaymentMode::find($id),
            'paymentModes' => PaymentMode::where('organization_id', organization()->id)->latest()->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(PaymentMode::rules());
        if (!empty($validated['is_active']) && $validated['is_active']) {
            // Deactivate all other fiscal years
            PaymentMode::where('is_active', true)->update(['is_active' => false]);
        }
        PaymentMode::where('id', $id)->update($validated);
        return redirect()->route('paymentMode.index')->with('success', 'Payment mode created successfully.');
    }

    public function destroy($id)
    {
        PaymentMode::destroy($id);
        return redirect()->route('paymentMode.index')->with('success', 'Payment mode deleted successfully.');
    }
}
