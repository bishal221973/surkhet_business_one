<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        return view('settings.expenseHead', [
            'expenseCategory' => new ExpenseCategory(),
            'expenseCategories' => ExpenseCategory::where('organization_id', organization()->id)->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(ExpenseCategory::rules());

        ExpenseCategory::create($validated);

        createTimeline(
            'New Expense Head Created',
            'New hexpense head ' . $validated['name'] . ' has been created by ' . auth()->user()->name,
            'cash'
        );

        return redirect()->route('expenseCategory.index')->with('success', 'Payment mode created successfully.');
    }

    public function edit($id)
    {
        return view('settings.expenseHead', [
            'expenseCategory' => ExpenseCategory::find($id),
            'expenseCategories' => ExpenseCategory::where('organization_id', organization()->id)->latest()->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(ExpenseCategory::rules());
        ExpenseCategory::where('id', $id)->update($validated);
        createTimeline(
            'Expense Head Updated',
            'Selected expense head ' . $validated['name'] . ' has been updated by ' . auth()->user()->name,
            'cash'
        );
        return redirect()->route('expenseCategory.index')->with('success', 'Payment mode created successfully.');
    }

    public function destroy($id)
    {
        $name = ExpenseCategory::find($id)->name;
        ExpenseCategory::destroy($id);
        createTimeline(
            'Expense Head Removed',
            'Selected expense head ' . $name . ' has been removed by ' . auth()->user()->name,
            'cash'
        );
        return redirect()->route('expenseCategory.index')->with('success', 'Payment mode deleted successfully.');
    }
}
