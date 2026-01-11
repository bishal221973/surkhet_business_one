<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddBank extends Component
{
    /**
     * Create a new component instance.
     */

    public $bank;
    public function __construct($bank=null)
    {
        $this->bank=$bank;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.add-bank');
    }
}
