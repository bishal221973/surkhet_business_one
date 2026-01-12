<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        return view('settings.unit', [
            'unit' => new Unit(),
            'units' => Unit::where('organization_id', organization()->id)->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Unit::rules());

        Unit::create($validated);

        createTimeline(
            'New Unit Created',
            'New unit ' . $validated['name'] . ' has been created by ' . auth()->user()->name,
            'circle'
        );

        return redirect()->route('unit.index')->with('success', 'Payment mode created successfully.');
    }

    public function edit($id)
    {
        return view('settings.unit', [
            'unit' => Unit::find($id),
            'units' => Unit::where('organization_id', organization()->id)->latest()->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(Unit::rules());

        Unit::where('id', $id)->update($validated);
        createTimeline(
            'Unit Updated',
            'Selected unit ' . $validated['name'] . ' has been updated by ' . auth()->user()->name,
            'circle'
        );
        return redirect()->route('unit.index')->with('success', 'Payment mode created successfully.');
    }

    public function destroy($id)
    {
        $name = Unit::find($id)->name;
        Unit::destroy($id);
        createTimeline(
            'Unit Removed',
            'Selected unit ' . $name . ' has been removed by ' . auth()->user()->name,
            'circle'
        );
        return redirect()->route('unit.index')->with('success', 'Payment mode deleted successfully.');
    }
}
