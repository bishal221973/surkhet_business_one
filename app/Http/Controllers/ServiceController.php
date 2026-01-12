<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Unit;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('settings.service', [
            'service' => new Service(),
            'services' => Service::with('unit')->where('organization_id', organization()->id)->latest()->get(),

        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Service::rules());

        Service::create($validated);

        createTimeline(
            'New Service Created',
            'New service ' . $validated['name'] . ' has been created by ' . auth()->user()->name,
            'circle'
        );

        return redirect()->route('service.index')->with('success', 'Payment mode created successfully.');
    }

    public function edit($id)
    {
        return view('settings.service', [
            'service' => Service::find($id),
            'services' => Service::where('organization_id', organization()->id)->latest()->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(Service::rules());

        Service::where('id', $id)->update($validated);
        createTimeline(
            'Service Updated',
            'Selected service ' . $validated['name'] . ' has been updated by ' . auth()->user()->name,
            'circle'
        );
        return redirect()->route('service.index')->with('success', 'Payment mode created successfully.');
    }

    public function destroy($id)
    {
        $name = Service::find($id)->name;
        Service::destroy($id);
        createTimeline(
            'Service Removed',
            'Selected service ' . $name . ' has been removed by ' . auth()->user()->name,
            'circle'
        );
        return redirect()->route('service.index')->with('success', 'Payment mode deleted successfully.');
    }
}
