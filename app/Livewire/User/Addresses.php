<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.user')]
class Addresses extends Component
{
    public function render()
    {
        return view('livewire.user.addresses');
    }
}