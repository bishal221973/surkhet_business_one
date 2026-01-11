<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(){
        $expenses=Expense::where('organization_id',organization()->id)->with('expenseHead','paymentMode','bank')->latest()->get();
        return view('expense.index',[
            'expenses'=>$expenses,
            'expense'=>new Expense(),
        ]);
    }

    public function store(Request $request){
        // return $request;

        $data=$request->validate(Expense::rules());
        $bank=Bank::find($request->bank_id);

        if($bank->balance < $request->amount){
            return back()->withInput()->with('error','Bank balance is not enough');
        }
        Expense::create($data);
        createTimeline(
            'New Expense Created',
            'New expense ' . $request->title . ' has been created by ' . auth()->user()->name,
            'cash'
        );
        return redirect()->route('expense.index')->with('success', 'Expense created successfully.');
    }

    public function edit($id)
    {
        $expenses = Expense::where('organization_id', organization()->id)->with('expenseHead', 'paymentMode', 'bank')->latest()->get();
        return view('expense.index', [
            'expenses' => $expenses,
            'expense' => Expense::find($id),
        ]);
    }

    // public function update(Request $request, $id)
    // {
    //     // return $request;
    //     $data = $request->validate(Expense::rules());
    //     $expense=Expense::find($id);
    //     $bank = Bank::find($request->bank_id);

    //     if ($bank->balance < $request->amount) {
    //         return back()->withInput()->with('error', 'Bank balance is not enough');
    //     }
    //     $expense->update($data);
    //     createTimeline(
    //         'Expense Updated',
    //         null,
    //         'cash'
    //     );
    //     return redirect()->route('expense.index')->with('success', 'Expense created successfully.');
    // }


    public function update(Request $request, $id)
    {
        $data = $request->validate(Expense::rules());

        $expense = Expense::findOrFail($id);
        $bank = Bank::findOrFail($request->bank_id);

        // old values
        $oldBankId = $expense->bank_id;
        $oldAmount = $expense->amount;

        // calculate available balance
        $availableBalance = $bank->balance;

        // if same bank, add old expense amount back
        if ($oldBankId == $bank->id) {
            $availableBalance += $oldAmount;
        }

        // check if enough balance
        if ($availableBalance < $request->amount) {
            return back()
                ->withInput()  // keep modal inputs
                ->with('error', 'Bank balance is not enough');
        }

        // now safe to update
        $expense->update($data);

        // Timeline
        createTimeline(
            'Expense Updated',
            null,
            'cash'
        );

        return redirect()->route('expense.index')
            ->with('success', 'Expense updated successfully.');
    }


    public function destroy($id){
        $name=Expense::find($id)->title;
        Expense::destroy($id);
        createTimeline(
            'Expense Removed',
            'Selected expense ' . $name . ' has been removed by ' . auth()->user()->name,
            'cash'
        );
        return redirect()->route('expense.index')->with('success', 'Expense deleted successfully.');
    }
}
