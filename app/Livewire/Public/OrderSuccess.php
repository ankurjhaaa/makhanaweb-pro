<?php

// File: app/Livewire/Public/OrderSuccess.php
namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class OrderSuccess extends Component
{
    public function mount()
    {
        if (!session()->has('success')) {
            return redirect()->route('checkout')->with('error', 'No order confirmation found.');
        }
    }

    public function render()
    {
        return view('livewire.public.order-success');
    }
}