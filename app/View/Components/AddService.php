<?php

namespace App\View\Components;

use Closure;
use App\Models\Unit;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class AddService extends Component
{
    /**
     * Create a new component instance.
     */
    public $service;
    public function __construct($service)
    {
        $this->service=$service;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $units = Unit::where('organization_id', organization()->id)->latest()->get();
        return view('components.add-service',[
            'units'=>$units
        ]);
    }
}
