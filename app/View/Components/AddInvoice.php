<?php

namespace App\View\Components;

use App\Models\Client;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddInvoice extends Component
{
    /**
     * Create a new component instance.
     */

    public $invoice;
    public function __construct($invoice=null)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $clients=Client::where('organization_id',organization()->id)->latest()->get();
        return view('components.add-invoice',[
            'clients'=>$clients,
        ]);
    }
}
