<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.user')]
class WishlistComponent extends Component
{
    public $wishlistItems = [];

    public function mount()
    {
        $this->loadWishlist();
    }

    public function loadWishlist()
    {
        // Load wishlist with product details for current user
        $this->wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->get();
    }

    public function toggleWishlist($productId)
    {
        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            // Remove from wishlist
            $existing->delete();
            session()->flash('success', 'Item removed from wishlist.');
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
            session()->flash('success', 'Item added to wishlist.');
        }

        $this->loadWishlist();
    }

    public function removeItem($id)
    {
        $item = Wishlist::find($id);
        if ($item && $item->user_id == Auth::id()) {
            $item->delete();
            $this->loadWishlist();
            session()->flash('success', 'Item removed from wishlist.');
        }
    }

    public function render()
    {
        return view('livewire.user.wishlist-component');
    }
}
