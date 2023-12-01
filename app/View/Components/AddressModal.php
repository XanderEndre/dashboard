<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddressModal extends Component
{
   

    public function __construct(public string $route, public array $addressOptions, public ?string $title = "")
    {
    
    }

    public function render()
    {
        return view('components.address-modal');
    }
}