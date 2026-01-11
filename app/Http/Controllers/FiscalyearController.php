<?php

namespace App\Http\Controllers;

use App\Models\Fiscalyear;
use Illuminate\Http\Request;

class FiscalyearController extends Controller
{
    public function index()
    {
        return view('settings.fiscalYear', [
            'fiscalYear' => new Fiscalyear(),
            'fiscalYears' => Fiscalyear::where('organization_id', organization()->id)->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Fiscalyear::rules());
        if (!empty($validated['is_active']) && $validated['is_active']) {
            // Deactivate all other fiscal years
            Fiscalyear::where('is_active', true)->update(['is_active' => false]);
        }
        Fiscalyear::create($validated);

        createTimeline(
            'New Fiscalyear Created',
            'New fiscalyear ' . $validated['name'] . ' has been created by ' . auth()->user()->name,
            'calender'
        );

        return redirect()->route('fiscalyear.index')->with('success', 'Fiscal year created successfully.');
    }

    public function edit($id)
    {
        return view('settings.fiscalYear', [
            'fiscalYear' => Fiscalyear::find($id),
            'fiscalYears' => Fiscalyear::where('organization_id', organization()->id)->latest()->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(Fiscalyear::rules());
        if (!empty($validated['is_active']) && $validated['is_active']) {
            // Deactivate all other fiscal years
            Fiscalyear::where('is_active', true)->update(['is_active' => false]);
        }
        Fiscalyear::where('id', $id)->update($validated);
        createTimeline(
            'Fiscalyear Updated',
            'Selected fiscalyear ' . $validated['name'] . ' has been updated by ' . auth()->user()->name,
            'calender'
        );
        return redirect()->route('fiscalyear.index')->with('success', 'Fiscal year created successfully.');
    }

    public function destroy($id)
    {
        $name=Fiscalyear::find($id)->name;
        Fiscalyear::destroy($id);
        createTimeline(
            'Fiscalyear Removed',
            'Selected fiscalyear ' . $name . ' has been removed by ' . auth()->user()->name,
            'calender'
        );
        return redirect()->route('fiscalyear.index')->with('success', 'Fiscal year deleted successfully.');
    }
}
