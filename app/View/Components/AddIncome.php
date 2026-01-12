<?php

namespace App\View\Components;

use Closure;
use App\Models\Bank;
use App\Models\Client;
use App\Models\PaymentMode;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class AddIncome extends Component
{
    /**
     * Create a new component instance.
     */

    public $income;
    public function __construct($income=null)
    {
        $this->income = $income;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $paymentModes = PaymentMode::where('organization_id', organization()->id)->latest()->get();
        $banks = Bank::where('organization_id', organization()->id)->latest()->get();
        $clients = Client::where('organization_id', organization()->id)->latest()->get();
        return view('components.add-income',[
            'paymentModes'=>$paymentModes,
            'banks'=>$banks,
            'clients'=>$clients
        ]);
    }
}
