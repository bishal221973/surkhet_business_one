<?php

namespace App\View\Components;

use App\Models\Bank;
use Closure;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\PaymentMode;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class AddPayment extends Component
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
        $clients=Client::where('organization_id',organization()->id)->latest()->get();
        $invoices=Invoice::where('organization_id',organization()->id)->latest()->get();
        $paymentModes=PaymentMode::where('organization_id', organization()->id)->latest()->get();
        $banks = Bank::where('organization_id',organization()->id)->latest()->get();
        return view('components.add-payment',[
            'invoices'=>$invoices,
            'clients'=>$clients,
            'paymentModes'=>$paymentModes,
            'banks'=>$banks
        ]);
    }
}
