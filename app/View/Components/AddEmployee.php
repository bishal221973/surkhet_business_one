<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddEmployee extends Component
{
    /**
     * Create a new component instance.
     */
    public $employee;
    public $roles;
    public function __construct($employee, $roles)
    {
        $this->employee = $employee;
        $this->roles = $roles;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.add-employee');
    }
}
