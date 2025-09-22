<?php

namespace App\Livewire\Public;

use App\Models\Product;
use App\Models\Review;
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
    public $reviews = [];
    public $rating;

    public $comment;



    public function mount($slug)
    {
        $this->loadWishlist();
        $this->productDetail = Product::where('slug', $slug)->with('category')->firstOrFail();

        $this->relatedProducts = Product::where('category_id', $this->productDetail->category_id)->where('id', '!=', $this->productDetail->id)->take(4)->get();

        $this->loadReviews();
    }

    public function loadReviews()
    {
        $this->reviews = $this->productDetail->reviews()->with('user')->latest()->take(10)->get();
    }

    public function addReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        Review::create([
            'product_id' => $this->productDetail->id,
            'user_id' => Auth::id(),
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->reset(['rating', 'comment']);
        $this->loadReviews();
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
            'reviews' => $this->reviews,
        ]);
    }
}
