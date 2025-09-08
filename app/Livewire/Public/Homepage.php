<?php

namespace App\Livewire\Public;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Homepage extends Component
{
    public function render()
    {
        $products = Product::all();
        return view('livewire.public.homepage', compact('products'));
    }
}
