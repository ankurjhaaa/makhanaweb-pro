<?php

namespace App\Livewire\Public;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.app')]

class Special extends Component
{
    public $name = "";
    public $specialcat = "";
    public $specialcatid = "";
    public $snacksproducts = [];
    public $spiceproducts = [];
    public $makhanaproducts = [];
    public $products = [];
    public function mount($name){
        $this->name = $name;
        $snacksproducts = Product::where('category_id',1)->get();
        $spiceproducts = Product::where('category_id',1)->get();
        $makhanaproducts = Product::where('category_id',1)->get();
        $this->snacksproducts = $snacksproducts;
        $this->spiceproducts = $spiceproducts;
        $this->makhanaproducts = $makhanaproducts;
    }
    public function render()
    {
        return view('livewire.public.special');
    }
}
