<?php

namespace App\Livewire\Public;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Wishlist;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Item extends Component
{
    public $productDetail;
    public $relatedProducts = [];
    public $wishlistIds = [];
    public $reviews = [];

    public $rating;
    public $comment;
    public $canReview = false;
    public $showReviewModal = false;
    public $breadcrumbs = [];

    public function mount($slug)
    {
        $this->loadWishlist();

        $this->productDetail = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        $this->relatedProducts = Product::where('category_id', $this->productDetail->category_id)
            ->where('id', '!=', $this->productDetail->id)
            ->take(4)
            ->get();

        $this->loadReviews();

        $this->buildBreadcrumbs($this->productDetail->category);

        if (Auth::check()) {
            $this->canReview = Order::where('user_id', Auth::id())
                ->where('status', 'delivered')
                ->whereHas('orderItems', function ($q) {
                    $q->where('product_id', $this->productDetail->id);
                })
                ->exists();
        }
    }

    protected function buildBreadcrumbs($category)
    {
        $breadcrumbs = [];
        while ($category) {
            $breadcrumbs[] = [
                'label' => $category->name,
                'url' => route('category', $category->slug),
            ];
            $category = $category->parent;
        }

        // Reverse order (grandparent → parent → current)
        $this->breadcrumbs = array_reverse($breadcrumbs);

        // Add Home at start
        array_unshift($this->breadcrumbs, [
            'label' => 'Home',
            'url' => route('home'),
        ]);
    }


    public function loadReviews()
    {
        $this->reviews = $this->productDetail
            ->reviews()
            ->with('user')
            ->latest()
            ->take(10)
            ->get();
    }

    public function addReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        $hasDeliveredOrder = Order::where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->whereHas('orderItems', function ($q) {
                $q->where('product_id', $this->productDetail->id);
            })
            ->exists();

        if (!$hasDeliveredOrder) {
            session()->flash('error', 'You can only review after delivery.');
            return;
        }

        Review::create([
            'product_id' => $this->productDetail->id,
            'user_id' => Auth::id(),
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->reset(['rating', 'comment', 'showReviewModal']);
        $this->loadReviews();

        session()->flash('success', 'Review submitted successfully!');
    }

    public function loadWishlist()
    {
        $this->wishlistIds = Wishlist::where('user_id', Auth::id())->pluck('product_id');
    }

    public function toggleWishlist($productId)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
        }

        $this->loadWishlist();
    }

    public function render()
    {
        return view('livewire.public.item', [
            'productDetail' => $this->productDetail,
            'relatedProducts' => $this->relatedProducts,
            'reviews' => $this->reviews,
            'canReview' => $this->canReview,
            'showReviewModal' => $this->showReviewModal,
        ]);
    }
}
