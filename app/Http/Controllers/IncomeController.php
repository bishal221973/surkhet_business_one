<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::where('organization_id', organization()->id)->with( 'paymentMode', 'bank')->latest()->get();
        return view('income.index', [
            'incomes' => $incomes,
            'income' => new Income(),
        ]);
    }

    public function store(Request $request)
    {
        // return $request;

        $data = $request->validate(Income::rules());
        Income::create($data);
        createTimeline(
            'New Income Created',
            'New income ' . $request->title . ' has been created by ' . auth()->user()->name,
            'cash'
        );
        return redirect()->route('income.index')->with('success', 'Income created successfully.');
    }

    public function edit($id)
    {
        $incomes = Income::where('organization_id', organization()->id)->with( 'paymentMode', 'bank')->latest()->get();
        return view('income.index', [
            'incomes' => $incomes,
            'income' => Income::find($id),
        ]);
    }




    public function update(Request $request, $id)
    {
        $data = $request->validate(Income::rules());

        $income = Income::findOrFail($id);


        // now safe to update
        $income->update($data);

        // Timeline
        createTimeline(
            'Income Updated',
            null,
            'cash'
        );

        return redirect()->route('income.index')
            ->with('success', 'Income updated successfully.');
    }


    public function destroy($id)
    {
        $name = Income::find($id)->title;
        Income::destroy($id);
        createTimeline(
            'Income Removed',
            'Selected income ' . $name . ' has been removed by ' . auth()->user()->name,
            'cash'
        );
        return redirect()->route('income.index')->with('success', 'Income deleted successfully.');
    }
}
