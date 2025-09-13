<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.user')]
class Wishlist extends Component
{
    public function render()
    {
        return view('livewire.user.wishlist');
    }
}