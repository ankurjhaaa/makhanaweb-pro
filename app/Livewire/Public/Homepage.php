<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Homepage extends Component
{
    public function render()
    {
        return view('livewire.public.homepage');
    }
}
