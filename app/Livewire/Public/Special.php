<?php

namespace App\Livewire\Public;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Category;   // ✅ not App\Livewire\Public\Category

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

        $category = Category::with([
            'products.reviews',
            'products.category'
        ])->find($id);

        $this->products = $category ? $category->products : collect();
    }

    public function render()
    {
        return view('livewire.public.special');
    }
}
