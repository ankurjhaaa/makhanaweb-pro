<?php

namespace App\Livewire\Public;

use App\Models\Product;
use App\Models\Wishlist;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Item extends Component
{
    public $activeTab = 'description';
    public $productDetail;
    public $relatedProducts = [];
    public $wishlistIds = [];

    
    public function mount($slug)
    {
        $this->loadWishlist();
        $this->productDetail = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        // Related products from same category
        $this->relatedProducts = Product::where('category_id', $this->productDetail->category_id)
            ->where('id', '!=', $this->productDetail->id)
            ->take(4)
            ->get();
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
        return view('livewire.public.item', [
            'productDetail' => $this->productDetail,
            'relatedProducts' => $this->relatedProducts,
        ]);
    }
}
