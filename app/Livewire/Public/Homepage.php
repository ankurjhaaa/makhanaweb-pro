<?php

namespace App\Livewire\Public;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Homepage extends Component
{
    public function render()
    {



        $product = Product::with('category')->first();


        $products = Product::select('id','name', 'image', 'price')->get();
        return view('livewire.public.homepage', compact('products'));
    }
}
