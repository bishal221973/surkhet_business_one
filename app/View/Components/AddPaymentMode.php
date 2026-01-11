<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

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
        return view('components.add-payment-mode');
    }
}
