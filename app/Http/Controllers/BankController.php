<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        return view('settings.bank', [
            'bank' => new Bank(),
            'banks' => Bank::where('organization_id', organization()->id)->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        // return $request;
        $validated = $request->validate(Bank::rules());
        Bank::create($validated);

        return redirect()->route('bank.index')->with('success', 'Fiscal year created successfully.');
    }

    public function edit($id)
    {
        return view('settings.bank', [
            'bank' => Bank::find($id),
            'banks' => Bank::where('organization_id', organization()->id)->latest()->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(Bank::rules());
        if (!empty($validated['is_active']) && $validated['is_active']) {
            // Deactivate all other fiscal years
            Bank::where('is_active', true)->update(['is_active' => false]);
        }
        Bank::where('id', $id)->update($validated);
        return redirect()->route('bank.index')->with('success', 'Fiscal year created successfully.');
    }

    public function destroy($id)
    {
        Bank::destroy($id);
        return redirect()->route('bank.index')->with('success', 'Fiscal year deleted successfully.');
    }
}
