<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddFiscalyear extends Component
{
    /**
     * Create a new component instance.
     */
    public $fiscalYear;
    public function __construct($fiscalYear)
    {
        $this->fiscalYear = $fiscalYear;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.add-fiscalyear');
    }
}
