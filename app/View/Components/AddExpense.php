<?php

namespace App\View\Components;

use App\Models\Bank;
use App\Models\ExpenseCategory;
use Closure;
use App\Models\PaymentMode;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class AddExpense extends Component
{
    /**
     * Create a new component instance.
     */
    public $expense;
    public function __construct($expense=null)
    {
        $this->expense = $expense;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $paymentModes = PaymentMode::where('organization_id', organization()->id)->latest()->get();
        $banks = Bank::where('organization_id', organization()->id)->latest()->get();
        $expenseHeads = ExpenseCategory::where('organization_id',organization()->id)->latest()->get();
        return view('components.add-expense',[
            'paymentModes'=>$paymentModes,
            'banks'=>$banks,
            'expenseHeads'=>$expenseHeads
        ]);
    }
}
