<?php

namespace App\Livewire\Public;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.app')]

class Special extends Component
{
    public $name = "";
    public $id = "";
    
    public $products = [];
    public function mount($name, $id)
    {
        $this->name = $name;
        $this->id = $id;
        $products = Product::where('category_id', $id)->get();
        $this->products = $products;

    }
    public function render()
    {
        return view('livewire.public.special');
    }
}
