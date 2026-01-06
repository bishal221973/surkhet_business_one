<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('clients.index',[
            'clients' => \App\Models\Client::all(),
            'client'=> new \App\Models\Client(),
        ]);
    }

    public function store(Request $request)
    {
        // return $request;
        $validated = $request->validate(\App\Models\Client::rules());

        \App\Models\Client::create($validated);

        return redirect()->route('client.index')->with('success', 'Client created successfully.');
    }


    public function edit($id)
    {
        $client = \App\Models\Client::findOrFail($id);

        return view('clients.index', [
            'clients' => \App\Models\Client::all(),
            'client' => $client,
        ]);
    }

    public function update(Request $request, $id)
    {
        $client = \App\Models\Client::findOrFail($id);

        $validated = $request->validate(\App\Models\Client::rules());

        $client->update($validated);

        return redirect()->route('client.index')->with('success', 'Client updated successfully.');
    }

    public function destroy($id)
    {
        $client = \App\Models\Client::findOrFail($id);
        $client->delete();

        return redirect()->route('client.index')->with('success', 'Client deleted successfully.');
    }

}
