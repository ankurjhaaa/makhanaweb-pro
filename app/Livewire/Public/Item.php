<?php

namespace App\Livewire\Public;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Item extends Component
{
    public $activeTab = 'description';
    public $productDetail;

    // Slug yaha milega route se
    public function mount($slug)
    {
        $this->productDetail = Product::where('slug', $slug)->with('category')->firstOrFail();
    }

    public function render()
    {
        return view('livewire.public.item', [
            'productDetail' => $this->productDetail
        ]);
    }
}
