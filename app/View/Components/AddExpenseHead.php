<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddExpenseHead extends Component
{
    /**
     * Create a new component instance.
     */

    public $expenseCategory;
    public function __construct($expenseCategory=null)
    {
        $this->expenseCategory = $expenseCategory;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.add-expense-head');
    }
}
