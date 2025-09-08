<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Layout;
#[Layout('layouts.app')]

class OrderSuccess extends Component
{
    public function render()
    {
        return view('livewire.public.order-success');
    }
}
