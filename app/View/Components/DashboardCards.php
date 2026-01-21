<?php

namespace App\View\Components;

use Closure;
use App\Models\Client;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class DashboardCards extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $clients=Client::where('organization_id',organization()->id)->latest()->count();
        $payments=Payment::where('fiscalyear_id', fiscalyear()->id)->where('organization_id', organization()->id)->latest()->sum('amount');
        $incomes = Income::where('fiscalyear_id', fiscalyear()->id)->where('organization_id', organization()->id)->latest()->sum('amount');
        $expenses = Expense::where('fiscalyear_id', fiscalyear()->id)->where('organization_id',organization()->id)->latest()->sum('amount');
        $invoices = Invoice::where('fiscalyear_id', fiscalyear()->id)->where('payable_amount', '>', 0)->latest()->sum('payable_amount');

        return view('components.dashboard-cards',[
            'clients'=>$clients,
            'payments'=>$payments,
            'incomes'=>$incomes,
            'expenses'=>$expenses,
            'invoices'=>$invoices
        ]);
    }
}
