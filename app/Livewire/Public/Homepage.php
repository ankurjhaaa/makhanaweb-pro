<?php

namespace App\Livewire\Public;

use App\Models\Category;
use App\Models\Product;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Wishlist;


#[Layout('layouts.app')]
class Homepage extends Component
{
    public $wishlistIds = [];

    public function mount()
    {
        $this->loadWishlist();
    }

    public function loadWishlist()
    {
        $this->wishlistIds = Wishlist::where('user_id', Auth::id())->pluck('product_id');
    }

    public function toggleWishlist($productId)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->first();

        if ($wishlist) {
            // Remove from wishlist
            $wishlist->delete();
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
        }

        $this->loadWishlist(); // Refresh ids for UI update
    }
    public function render()
    {



        $product = Product::with('category')->first();


        $products = Product::all();
        return view('livewire.public.homepage', compact('products'));
    }
}
