<?php

namespace App\View\Components;

use Closure;
use App\Models\Invoice;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class AddPaymentMode extends Component
{
    /**
     * Create a new component instance.
     */

    public $paymentMode;
    public function __construct($paymentMode)
    {
        $this->paymentMode = $paymentMode;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $invoices=Invoice::where('organization_id',organization()->id)->latest()->get();
        return view('components.add-payment-mode',[
            'invoices'=>$invoices
        ]);
    }
}
