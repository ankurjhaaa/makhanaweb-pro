<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.app')]

class Special extends Component
{
    public $name = "";
    public function mount($name){
        $this->name = $name;
    }
    public function render()
    {
        return view('livewire.public.special');
    }
}
